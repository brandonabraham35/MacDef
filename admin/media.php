<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_login();

$pageTitle = 'Media Library';
include __DIR__ . '/includes/header.php';

$img_dir = dirname(__DIR__) . '/uploads/images/';
$doc_dir = dirname(__DIR__) . '/uploads/documents/';

if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);
if (!is_dir($doc_dir)) mkdir($doc_dir, 0755, true);

// Fix Security: Validate file path to prevent path traversal
function validate_media_path($path) {
    $real_base = realpath(dirname(__DIR__) . '/uploads');
    $real_file = realpath(dirname(__DIR__) . '/' . $path);
    return ($real_file && strpos($real_file, $real_base) === 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        $file = $_POST['file_path'];
        if (validate_media_path($file)) {
            delete_upload($file);
            $_SESSION['flash'] = 'File deleted.';
        } else {
            $_SESSION['flash_err'] = 'Invalid file path.';
        }
    } else {
        $_SESSION['flash_err'] = 'Invalid token.';
    }
    redirect('media.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload_media'])) {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        $kind = $_POST['media_kind'] === 'document' ? 'document' : 'image';
        $up = handle_upload($_FILES['upload_media'], $kind);
        if ($up['ok']) {
            $_SESSION['flash'] = 'File uploaded successfully.';
        } else {
            $_SESSION['flash_err'] = $up['error'];
        }
    }
    redirect('media.php');
}

$flash = $_SESSION['flash'] ?? '';
$err = $_SESSION['flash_err'] ?? '';
unset($_SESSION['flash'], $_SESSION['flash_err']);

$search = clean($_GET['q'] ?? '');

function get_files($dir, $web_path, $search = '') {
    $files = [];
    if (is_dir($dir)) {
        foreach (scandir($dir) as $f) {
            if ($f !== '.' && $f !== '..') {
                if ($search && stripos($f, $search) === false) continue;
                $files[] = [
                    'name' => $f,
                    'path' => $web_path . $f,
                    'size' => filesize($dir . $f),
                    'time' => filemtime($dir . $f)
                ];
            }
        }
    }
    usort($files, fn($a, $b) => $b['time'] <=> $a['time']);
    return $files;
}

$images = get_files($img_dir, 'uploads/images/', $search);
$docs = get_files($doc_dir, 'uploads/documents/', $search);
?>

<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif;?>
<?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif;?>

<div class="panel mb-4">
    <h3>Upload New Media</h3>
    <form method="post" enctype="multipart/form-data" class="row g-3 align-items-end">
        <?= csrf_field() ?>
        <div class="form-field col-md-4">
            <label>Select File</label>
            <input type="file" name="upload_media" required>
        </div>
        <div class="form-field col-md-3">
            <label>Media Type</label>
            <select name="media_kind" class="form-select">
                <option value="image">Image</option>
                <option value="document">Document (PDF/DOC)</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn-primary" type="submit">Upload</button>
        </div>
    </form>
</div>

<div class="panel mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="form-field col-md-6">
            <label>Search Media</label>
            <input type="text" name="q" value="<?= e($search) ?>" placeholder="Filter by filename...">
        </div>
        <div class="col-md-2">
            <button class="btn-primary" type="submit">Search</button>
        </div>
        <?php if($search): ?>
        <div class="col-md-2">
            <a href="media.php" class="btn-ghost">Clear</a>
        </div>
        <?php endif; ?>
    </form>
</div>

<div class="panel">
    <h3>Images</h3>
    <?php if(empty($images)): ?>
        <p class="empty">No images found.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
            <?php foreach ($images as $img): ?>
            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 10px; text-align: center;">
                <img src="../<?= e($img['path']) ?>" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
                <div style="font-size: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= e($img['name']) ?>"><?= e($img['name']) ?></div>
                <div style="margin-top: 5px;">
                    <form method="post" class="confirm-delete" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="delete_file" value="1">
                        <input type="hidden" name="file_path" value="<?= e($img['path']) ?>">
                        <button type="submit" style="background:none; border:none; color:red; font-size:12px; cursor:pointer;">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h3 style="margin-top: 40px;">Documents</h3>
    <?php if(empty($docs)): ?>
        <p class="empty">No documents found.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr><th>Filename</th><th>Size</th><th>Uploaded</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach ($docs as $doc): ?>
                <tr>
                    <td><?= e($doc['name']) ?></td>
                    <td><?= round($doc['size'] / 1024, 2) ?> KB</td>
                    <td><?= date('Y-m-d H:i', $doc['time']) ?></td>
                    <td>
                        <a href="../<?= e($doc['path']) ?>" target="_blank">View</a> |
                        <form method="post" class="confirm-delete" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="delete_file" value="1">
                            <input type="hidden" name="file_path" value="<?= e($doc['path']) ?>">
                            <button type="submit" class="link-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

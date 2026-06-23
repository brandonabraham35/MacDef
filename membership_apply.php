<?php
$page_title = 'Membership Application';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/EmailService.php';

$status = '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['membership_submit'])) {
    $name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $occupation = sanitize($_POST['occupation']);
    $type = sanitize($_POST['membership_type']);

    try {
        $stmt = db()->prepare("INSERT INTO memberships (full_name, email, phone, address, occupation, membership_type, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
        $stmt->execute([$name, $email, $phone, $address, $occupation, $type]);

        // Send Confirmation to User
        EmailService::sendUserConfirmation($email, $name, 'Membership Application');

        // Send Notification to Admin
        EmailService::sendAdminNotification('New Membership Application', [
            'Applicant Name' => $name,
            'Email' => $email,
            'Phone' => $phone,
            'Membership Type' => $type,
            'Occupation' => $occupation
        ], "Address: " . $address);

        $status = 'success';
        $msg = 'Your membership application has been submitted successfully. Our team will review it and get back to you.';
    } catch (Exception $e) {
        $status = 'danger';
        $msg = 'Sorry, we could not process your application. Please try again.';
    }
}
?>

<section class="section-padding bg-navy text-white">
    <div class="container text-center">
        <span class="section-tag text-gold">Join Us</span>
        <h1 class="display-4 fw-bold mb-3">Membership Application</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px;">Be a part of a community dedicated to the preservation and development of Ma'di culture.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg p-4 p-md-5">
                    <?php if ($msg): ?>
                        <div class="alert alert-<?= $status ?> mb-4"><?= $msg ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <h5 class="fw-bold text-navy border-bottom pb-2 mb-3">Personal Information</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Full Name</label>
                                <input type="text" name="full_name" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Email Address</label>
                                <input type="email" name="email" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Phone Number</label>
                                <input type="text" name="phone" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Occupation</label>
                                <input type="text" name="occupation" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-uppercase">Residential Address</label>
                                <textarea name="address" class="form-control bg-light border-0" rows="2"></textarea>
                            </div>

                            <div class="col-md-12 mt-5">
                                <h5 class="fw-bold text-navy border-bottom pb-2 mb-3">Membership Details</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Membership Type</label>
                                <select name="membership_type" class="form-select bg-light border-0" required>
                                    <option value="Ordinary">Ordinary Member</option>
                                    <option value="Associate">Associate Member</option>
                                    <option value="Honorary">Honorary Member</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" required id="terms">
                                    <label class="form-check-label small text-muted" for="terms">
                                        I agree to abide by the MACDEF Constitution and Membership Charter.
                                    </label>
                                </div>
                                <button type="submit" name="membership_submit" class="btn btn-gold btn-lg px-5 py-3 fw-bold">SUBMIT APPLICATION</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

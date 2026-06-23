<?php
$page_title = 'Support MACDEF';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/EmailService.php';

$status = '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donate_submit'])) {
    $name = sanitize($_POST['donor_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $type = sanitize($_POST['donation_type']);
    $amount = (float)$_POST['amount'];
    $message = sanitize($_POST['message']);

    try {
        $stmt = db()->prepare("INSERT INTO donations (donor_name, email, phone, donation_type, amount, message, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
        $stmt->execute([$name, $email, $phone, $type, $amount, $message]);

        $donor_id = db()->lastInsertId();

        // Send Emails
        

        // To Admin
        $admin_body = "<h3>New Donation Interest</h3>
                       <p><strong>Name:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Phone:</strong> $phone</p>
                       <p><strong>Type:</strong> $type</p>
                       <p><strong>Amount:</strong> $amount</p>
                       <p><strong>Message:</strong> $message</p>";
        EmailService::sendEmail(ADMIN_EMAIL, "New Donation: $name", $admin_body);

        // To Donor
        $donor_body = "<h3>Thank You for Your Support!</h3>
                       <p>Dear $name,</p>
                       <p>We have received your donation interest of <strong>$type</strong>. Our team will contact you shortly with further instructions.</p>
                       <p>Thank you for supporting MACDEF and the Ma'di community.</p>";
        EmailService::sendEmail($email, "Thank You for Supporting MACDEF", $donor_body);

        $status = 'success';
        $msg = 'Thank you for your interest in supporting MACDEF! We have sent a confirmation email to you.';
    } catch (Exception $e) {
        $status = 'danger';
        $msg = 'Sorry, something went wrong. Please try again later.';
    }
}

$methods = db()->query("SELECT * FROM donation_methods WHERE is_active=1")->fetchAll();
?>

<section class="section-padding bg-navy text-white">
    <div class="container text-center">
        <span class="section-tag text-gold">Make a Difference</span>
        <h1 class="display-4 fw-bold mb-3">Support MACDEF</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px;">Your contribution helps us preserve Ma'di heritage and empower our community for a better future.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="pe-lg-4">
                    <h2 class="fw-bold text-navy mb-4">Why Support MACDEF?</h2>
                    <p class="text-muted mb-4">MACDEF is committed to social transformation, cultural preservation, and community empowerment. Your support enables us to:</p>
                    <ul class="list-unstyled mb-5">
                        <li class="mb-3 d-flex"><i class="ri-checkbox-circle-fill text-gold me-3 fs-4"></i> <span>Preserve and promote the rich Ma'di cultural heritage and language.</span></li>
                        <li class="mb-3 d-flex"><i class="ri-checkbox-circle-fill text-gold me-3 fs-4"></i> <span>Empower youth through leadership training and skills development.</span></li>
                        <li class="mb-3 d-flex"><i class="ri-checkbox-circle-fill text-gold me-3 fs-4"></i> <span>Support community-led development initiatives and partnerships.</span></li>
                        <li class="mb-3 d-flex"><i class="ri-checkbox-circle-fill text-gold me-3 fs-4"></i> <span>Provide resources for research and documentation of Ma'di traditions.</span></li>
                    </ul>

                    <h3 class="fw-bold text-navy mb-4">How to Give</h3>
                    <div class="accordion" id="donationAccordion">
                        <?php foreach ($methods as $i => $m): ?>
                        <div class="accordion-item mb-3 border-0 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $i===0?'':'collapsed' ?> fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#method<?= $m['id'] ?>">
                                    <?= e($m['method_name']) ?>
                                </button>
                            </h2>
                            <div id="method<?= $m['id'] ?>" class="accordion-collapse collapse <?= $i===0?'show':'' ?>" data-bs-parent="#donationAccordion">
                                <div class="accordion-body">
                                    <div class="bg-light p-3 rounded mb-3">
                                        <strong>Details:</strong><br>
                                        <?= nl2br(e($m['account_details'])) ?>
                                    </div>
                                    <p class="small text-muted mb-0"><?= nl2br(e($m['instructions'])) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-lg p-4 p-md-5">
                    <h3 class="fw-bold text-navy mb-4">Donation Interest Form</h3>
                    <?php if ($msg): ?>
                        <div class="alert alert-<?= $status ?>"><?= $msg ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Full Name</label>
                            <input type="text" name="donor_name" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Phone Number</label>
                            <input type="text" name="phone" class="form-control form-control-lg bg-light border-0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Donation Type</label>
                            <select name="donation_type" class="form-select form-select-lg bg-light border-0" required>
                                <option value="Mobile Money">Mobile Money</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="In-kind">In-kind Support</option>
                                <option value="Volunteer">Volunteer Support</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Proposed Amount (UGX)</label>
                            <input type="number" name="amount" class="form-control form-control-lg bg-light border-0" placeholder="0.00">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Message / Details</label>
                            <textarea name="message" class="form-control form-control-lg bg-light border-0" rows="4"></textarea>
                        </div>
                        <button type="submit" name="donate_submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold">SUBMIT INTEREST</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

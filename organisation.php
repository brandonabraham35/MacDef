<?php
$page_title = 'Structure';
require_once __DIR__ . '/includes/header.php';
?>
<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Governance</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Organisational Structure</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">MACDEF is governed by a transparent and accountable leadership structure dedicated to our mission.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="h3 fw-bold mb-4 text-navy">Governance Framework</h2>
                <p class="text-muted mb-4">MACDEF operates through a clear hierarchical structure to ensure effective decision-making and implementation of programs. Our governance consists of:</p>
                <div class="accordion" id="structureAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold text-navy bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                The General Assembly
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#structureAccordion">
                            <div class="accordion-body text-muted">
                                The supreme policy-making organ of the Foundation, comprising all registered members.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-navy bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                The Board of Directors
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#structureAccordion">
                            <div class="accordion-body text-muted">
                                Responsible for strategic direction, policy formulation, and oversight of the Secretariat.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-navy bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                The Secretariat
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#structureAccordion">
                            <div class="accordion-body text-muted">
                                The executive arm led by the Executive Director, responsible for day-to-day operations and project implementation.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-5 bg-navy text-white rounded shadow text-center">
                    <i class="ri-node-tree display-1 text-gold mb-4 d-block"></i>
                    <h3 class="fw-bold mb-3">Our Organogram</h3>
                    <p class="mb-4 opacity-75">Download the complete MACDEF organisational chart for a detailed view of our leadership and department relationships.</p>
                    <a href="uploads/documents/MACDEF-Organogram.pdf" target="_blank" class="btn btn-gold btn-lg rounded-pill">
                        <i class="ri-file-download-line me-2"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

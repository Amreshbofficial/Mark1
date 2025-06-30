<?php
$pageTitle = "Contact Us";
require_once 'includes/header.php';
require_once 'includes/config.php';
?>

<section class="contact-section">
    <div class="contact-container">
        <div class="contact-info">
            <h2>Contact Information</h2>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>123 Commerce Street, Business City, BC 12345</p>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <p>+1 (123) 456-7890</p>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <p>support@brandbazaar.com</p>
            </div>
            <div class="info-item">
                <i class="fas fa-clock"></i>
                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                <p>Saturday: 10:00 AM - 4:00 PM</p>
            </div>
        </div>
        
        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="send_message.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>

<div class="contact-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.678901234567!2d-73.987654321!3d40.123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDA3JzI0LjQiTiA3M8KwNTknMDcuMiJX!5e0!3m2!1sen!2sus!4v1234567890123" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
    </iframe>
</div>

<?php require_once 'includes/footer.php'; ?>
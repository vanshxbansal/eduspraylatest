<?php
/**
 * Footer Include
 * Reusable footer component for PHP pages
 */
?>
<!-- Footer -->
<footer style="background: #1a1a2e; color: white; padding: 60px 0 30px;">
    <div class="container">
        <div class="row">
            <!-- About Column -->
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="images/02.png" alt="Eduspray India" style="height: 50px; margin-bottom: 20px;">
                <p style="color: rgba(255,255,255,0.7); line-height: 1.8;">
                    Eduspray is India's most trusted educational counselor helping students find the right courses, colleges, and universities based on their career goals.
                </p>
                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: background 0.3s;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: background 0.3s;">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: background 0.3s;">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: background 0.3s;">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: background 0.3s;">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 25px;">Quick Links</h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;"><a href="index.html" style="color: rgba(255,255,255,0.7); text-decoration: none;">Home</a></li>
                    <li style="margin-bottom: 12px;"><a href="about.html" style="color: rgba(255,255,255,0.7); text-decoration: none;">About Us</a></li>
                    <li style="margin-bottom: 12px;"><a href="contact.html" style="color: rgba(255,255,255,0.7); text-decoration: none;">Contact</a></li>
                    <li style="margin-bottom: 12px;"><a href="blog.html" style="color: rgba(255,255,255,0.7); text-decoration: none;">Blog</a></li>
                    <li style="margin-bottom: 12px;"><a href="Faq.html" style="color: rgba(255,255,255,0.7); text-decoration: none;">FAQ</a></li>
                </ul>
            </div>
            
            <!-- Courses -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 25px;">Top Courses</h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;"><a href="course.php?slug=btech" style="color: rgba(255,255,255,0.7); text-decoration: none;">B.Tech</a></li>
                    <li style="margin-bottom: 12px;"><a href="course.php?slug=bba" style="color: rgba(255,255,255,0.7); text-decoration: none;">BBA</a></li>
                    <li style="margin-bottom: 12px;"><a href="course.php?slug=bca" style="color: rgba(255,255,255,0.7); text-decoration: none;">BCA</a></li>
                    <li style="margin-bottom: 12px;"><a href="course.php?slug=medical" style="color: rgba(255,255,255,0.7); text-decoration: none;">Medical</a></li>
                    <li style="margin-bottom: 12px;"><a href="course.php?slug=journalism" style="color: rgba(255,255,255,0.7); text-decoration: none;">Journalism</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 25px;">Contact Info</h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 15px; display: flex; gap: 15px; color: rgba(255,255,255,0.7);">
                        <i class="fas fa-map-marker-alt" style="color: #667eea; margin-top: 5px;"></i>
                        <span>New Delhi, India</span>
                    </li>
                    <li style="margin-bottom: 15px; display: flex; gap: 15px; color: rgba(255,255,255,0.7);">
                        <i class="fas fa-phone" style="color: #667eea;"></i>
                        <a href="tel:+918595684716" style="color: rgba(255,255,255,0.7); text-decoration: none;">+91 8595684716</a>
                    </li>
                    <li style="margin-bottom: 15px; display: flex; gap: 15px; color: rgba(255,255,255,0.7);">
                        <i class="fas fa-envelope" style="color: #667eea;"></i>
                        <a href="mailto:contact@eduspray.in" style="color: rgba(255,255,255,0.7); text-decoration: none;">contact@eduspray.in</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 40px; padding-top: 30px; text-align: center; color: rgba(255,255,255,0.5);">
            <p style="margin: 0;">© <?php echo date('Y'); ?> Eduspray India. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- WhatsApp Button -->
<a href="https://wa.me/918595684716" target="_blank" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4); z-index: 999; transition: transform 0.3s;">
    <i class="fab fa-whatsapp"></i>
</a>









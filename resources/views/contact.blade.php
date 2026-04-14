@extends('layout.main')

@section('hyasabicontentauncha')
<!-- CONTACT PAGE -->
<section class="contact-hero-section">
    <div class="container">
        <div class="contact-hero-content">
            <h1 class="contact-title">Get in touch</h1>
            <p class="contact-subtitle">We'd love to hear from you. Send us a message or reach out directly.</p>
        </div>
    </div>
</section>

<!-- CONTACT CONTENT SECTION -->
<section class="contact-content-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Send a Message Form -->
            <div class="contact-form-card">
                <h2 class="form-title">Send a message</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                    @csrf
                    
                    <!-- Your name -->
                    <div class="form-group">
                        <label for="name" class="form-label">Your name</label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="e.g. Ram Sharma" required>
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email address -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="e.g. ram@email.com" required>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone (optional) -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone (optional)</label>
                        <input type="tel" id="phone" name="phone" class="form-input" placeholder="e.g. 98XXXXXXXX">
                        @error('phone')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea id="message" name="message" class="form-textarea" rows="5" placeholder="Write your message here..." required></textarea>
                        @error('message')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="send-message-btn">Send message</button>
                </form>
            </div>

            <!-- Contact Details -->
            <div class="contact-details-card">
                <h2 class="details-title">Contact details</h2>
                
                <div class="contact-info">
                    <!-- Phone/WhatsApp -->
                    <div class="contact-item">
                        <div class="contact-icon phone-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <span class="contact-label">Phone / WhatsApp</span>
                            <span class="contact-value">+977 9816618275</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="contact-item">
                        <div class="contact-icon email-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <span class="contact-label">Email</span>
                            <span class="contact-value">sanskriti@bazar.com</span>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="contact-item">
                        <div class="contact-icon location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <span class="contact-label">Location</span>
                            <span class="contact-value">Thamel, Kathmandu</span>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="business-hours">
                    <h3 class="hours-title">Business hours</h3>
                    <div class="hours-list">
                        <div class="hours-item">
                            <span class="day">Sunday – Friday</span>
                            <span class="time">10:00am – 6:00pm</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Saturday</span>
                            <span class="time closed">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Follow Us -->
                <div class="social-section">
                    <h3 class="social-title">Follow us</h3>
                    <div class="social-buttons">
                        <a href="#" class="social-btn facebook-btn">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="social-btn instagram-btn">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* CONTACT PAGE STYLES */
.contact-hero-section {
    background: linear-gradient(135deg, rgba(102,126,234,0.8) 0%, rgba(118,75,162,0.8) 100%);
    color: white;
    padding: 100px 0 60px;
    text-align: center;
}

.contact-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.contact-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    font-weight: 400;
    max-width: 600px;
    margin: 0 auto;
}

.contact-content-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    max-width: 1000px;
    margin: 0 auto;
}

/* Contact Form Card */
.contact-form-card {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.95rem;
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.form-input, .form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: #2d3748;
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input::placeholder, .form-textarea::placeholder {
    color: #a0aec0;
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.send-message-btn {
    width: 100%;
    background: #2d3748;
    color: white;
    padding: 14px 24px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.send-message-btn:hover {
    background: #1a202c;
    transform: translateY(-1px);
}

/* Contact Details Card */
.contact-details-card {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.details-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 2rem;
}

.contact-info {
    margin-bottom: 2.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.phone-icon {
    background: #e3f2fd;
    color: #1976d2;
}

.email-icon {
    background: #e8f5e8;
    color: #388e3c;
}

.location-icon {
    background: #fce4ec;
    color: #c2185b;
}

.contact-text {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.contact-label {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
}

.contact-value {
    font-size: 1rem;
    color: #2d3748;
    font-weight: 600;
}

/* Business Hours */
.business-hours {
    margin-bottom: 2.5rem;
}

.hours-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
}

.hours-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.hours-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.day {
    font-size: 0.95rem;
    color: #4a5568;
    font-weight: 500;
}

.time {
    font-size: 0.95rem;
    color: #2d3748;
    font-weight: 600;
}

.time.closed {
    color: #e53e3e;
}

/* Social Section */
.social-section {
    margin-bottom: 0;
}

.social-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
}

.social-buttons {
    display: flex;
    gap: 1rem;
}

.social-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 10px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    flex: 1;
    justify-content: center;
}

.facebook-btn {
    color: #1877f2;
    border-color: #1877f2;
}

.facebook-btn:hover {
    background: #1877f2;
    color: white;
}

.instagram-btn {
    color: #e4405f;
    border-color: #e4405f;
}

.instagram-btn:hover {
    background: #e4405f;
    color: white;
}

/* Alert Styles */
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.error-text {
    display: block;
    color: #e53e3e;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-title {
        font-size: 2.5rem;
    }

    .contact-subtitle {
        font-size: 1.1rem;
    }

    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .contact-form-card,
    .contact-details-card {
        padding: 2rem;
    }

    .social-buttons {
        flex-direction: column;
    }

    .social-btn {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .contact-hero-section {
        padding: 80px 0 50px;
    }

    .contact-content-section {
        padding: 60px 0;
    }

    .contact-form-card,
    .contact-details-card {
        padding: 1.5rem;
    }

    .contact-title {
        font-size: 2rem;
    }

    .form-title,
    .details-title {
        font-size: 1.3rem;
    }
}
</style>
@endsection

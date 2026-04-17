@extends('layout.main')

@section('hyasabicontentauncha')
<!-- ABOUT US PAGE -->
<section class="about-hero-section">
    <div class="container">
        <div class="about-hero-content">
            <h1 class="about-title">About Sanskriti Bazar</h1>
            <p class="about-subtitle">Preserving Nepal's Musical Heritage Through Traditional Instruments</p>
        </div>
    </div>
</section>

<!-- ABOUT CONTENT SECTION -->
<section class="about-content-section">
    <div class="container">
        <!-- Our Story -->
        <div class="about-block">
            <div class="about-text">
                <h2 class="section-title">Our Story</h2>
                <p class="about-description">
                    The biggest market of traditional musical instruments in Nepal is Sanskriti Bazar. We love and care about preserving and promoting rich musical heritage of Nepal by introducing you to authentic and handcrafted musical instruments produced by local vendors.
                </p>
                <p class="about-description">
                    Established with the idea of preserving Nepal musical culture, we deal directly with the artisans of various areas of Nepal who have been producing these beautiful instruments over generations. 
                </p>
            </div>
            <div class="about-image">
                <div class="image-placeholder">

                </div>
            </div>
        </div>

        <!-- What We Offer -->
        <div class="about-block reverse">
            <div class="about-image">
                <div class="image-placeholder">
    
                </div>
            </div>
            <div class="about-text">
                <h2 class="section-title">What We Offer</h2>
                <div class="features-list">
                    <div class="feature-item">
                    
                        <div>
                            <h4>Authentic Instruments</h4>
                            <p>All instruments are made by the Nepali masters and artisans in traditional ways.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                       
                        <div>
                            <h4>Safe Delivery</h4>
                            <p>Your instruments are safely packaged and delivered to you.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                      
                        <div>
                            <h4>Cultural Preservation</h4>
                            <p>Promoting traditional craftsmanship and preserving our heritage</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Mission -->
        <div class="mission-section">
            <div class="mission-content">
                <h2 class="section-title">Our Mission</h2>
                <p class="mission-text">
                    To help preserve the musical heritage of Nepal by offering a platform where traditional instrument makers get to display their crafts and those who love Nepali music get to find their way to the original Nepali instruments. In our opinion, each instrument is a narrative of our culture and traditions.
                </p>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="why-choose-section">
            <div class="why-choose-header">
                <h2 class="why-choose-title">Why choose Sanskriti Bazar?</h2>
                <p class="why-choose-subtitle">Authentic Nepali instruments, delivered with care and purpose.</p>
            </div>
            
            <div class="why-choose-grid">
                <!-- Quality Guaranteed -->
                <div class="why-choose-card">
                    <div class="card-icon ">
                        
                    </div>
                    <h4 class="card-title">Quality guaranteed</h4>
                    <p class="card-description">Every instrument is thoroughly checked for quality and sound authenticity.</p>
                </div>

                <!-- Support Local Artists -->
                <div class="why-choose-card">
                    <div class="card-icon ">

                    </div>
                    <h4 class="card-title">Support local artists</h4>
                    <p class="card-description">Your purchase directly helps Nepali artisans and their families.</p>
                </div>

                <!-- Secure Shopping -->
                <div class="why-choose-card">
                    <div class="card-icon">
              
                    </div>
                    <h4 class="card-title">Secure shopping</h4>
                    <p class="card-description">Safe and secure payment options with full buyer guarantees.</p>
                </div>

                <!-- Customer Support -->
                <div class="why-choose-card">
                    <div class="card-icon ">   
                    </div>
                    <h4 class="card-title">Customer support</h4>
                    <p class="card-description">Friendly service to help you find the perfect instrument.</p>
                </div>
            </div>
        </div>

    
        </div>
    </div>
</section>

<style>
/* ABOUT PAGE STYLES */
.about-hero-section {
    background: #253A4E;
    color: black;
    padding: 120px 0 80px;
    text-align: center;
}

.about-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.about-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    color: white;
}

.about-content-section {
    padding: 80px 0;
    background: transparent;
}

.about-block {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    margin-bottom: 80px;
}

.about-block.reverse {
    direction: rtl;
}

.about-block.reverse > * {
    direction: ltr;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #000000ff;
    margin-bottom: 2rem;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.about-description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #000000;
    margin-bottom: 1.5rem;
}

.about-image {
    background: url('../../uploads/Photography.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    display: flex;
    justify-content: center;
    align-items: center;
}

.image-placeholder {
    width: 300px;
    height: 250px;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.image-placeholder i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.8;
}

.image-placeholder p {
    font-size: 1.1rem;
    font-weight: 600;
    text-align: center;
}

.features-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.feature-item i {
    font-size: 1.5rem;
    color: #000000ff;
    margin-top: 0.25rem;
    min-width: 24px;
}

.feature-item h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #000000ff;
    margin-bottom: 0.5rem;
}

.feature-item p {
    color: #000000ff;
    line-height: 1.6;
}

.mission-section {
    background: rgba(255,255,255,0.05);
    padding: 60px 40px;
    border-radius: 20px;
    text-align: center;
    margin: 80px 0;
    backdrop-filter: blur(10px);
}

.mission-text {
    font-size: 1.2rem;
    line-height: 1.8;
    color: #000000ff;
    max-width: 800px;
    margin: 0 auto 3rem;
}

.mission-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 3rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1rem;
    color: #E2E8F0;
    font-weight: 600;
}

.why-choose-section {
    margin: 80px 0;
    text-align: center;
}

.why-choose-header {
    margin-bottom: 4rem;
}

.why-choose-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
    text-align: center;
}

.why-choose-subtitle {
    font-size: 1.2rem;
    color: #718096;
    font-weight: 400;
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.why-choose-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.why-choose-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 16px;
    text-align: left;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.why-choose-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.card-icon i {
    font-size: 1.5rem;
    color: white;
}

.blue-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.green-icon {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
}

.orange-icon {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
}

.gray-icon {
    background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.card-description {
    color: #718096;
    line-height: 1.6;
    font-size: 1rem;
    margin: 0;
}

.about-cta {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 40px;
    border-radius: 20px;
    text-align: center;
    color: white;
    margin-top: 80px;
}

.about-cta h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.about-cta p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
    padding: 15px 30px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-primary {
    background: white;
    color: #667eea;
}

.btn-primary:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-secondary:hover {
    background: white;
    color: #667eea;
}

/* Responsive Design */
@media (max-width: 768px) {
    .about-title {
        font-size: 2.5rem;
    }
    
    .about-subtitle {
        font-size: 1.1rem;
    }
    
    .about-block {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .about-block.reverse {
        direction: ltr;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .why-choose-title {
        font-size: 2rem;
    }
    
    .why-choose-subtitle {
        font-size: 1.1rem;
    }
    
    .why-choose-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .why-choose-card {
        padding: 2rem 1.5rem;
    }
    
    .mission-stats {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary, .btn-secondary {
        width: 200px;
    }
}

@media (max-width: 480px) {
    .about-hero-section {
        padding: 80px 0 60px;
    }
    
    .about-content-section {
        padding: 60px 0;
    }
    
    .why-choose-section {
        margin: 60px 0;
    }
    
    .why-choose-header {
        margin-bottom: 3rem;
    }
    
    .why-choose-title {
        font-size: 1.8rem;
    }
    
    .why-choose-card {
        padding: 1.5rem;
    }
    
    .card-icon {
        width: 40px;
        height: 40px;
    }
    
    .card-icon i {
        font-size: 1.25rem;
    }
    
    .mission-section,
    .about-cta {
        padding: 40px 20px;
        margin: 60px 0;
    }
    
    .image-placeholder {
        width: 250px;
        height: 200px;
    }
}
</style>
@endsection
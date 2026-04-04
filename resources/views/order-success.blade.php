@extends('layout.main')

@section('hyasabicontentauncha')
<div class="order-success-page">
    <div class="container">
        <div class="success-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="success-title">Order Placed Successfully!</h1>
            
            <p class="success-message">
                Thank you for your order! We have received your order details and will contact you soon for delivery confirmation.
            </p>
            
            <div class="order-info">
                <div class="info-item">
                    <i class="fas fa-truck"></i>
                    <div class="info-content">
                        <h3>Free Delivery</h3>
                        <p>Your order will be delivered to your doorstep</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div class="info-content">
                        <h3>We'll Contact You</h3>
                        <p>Our team will call you to confirm delivery details</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <div class="info-content">
                        <h3>Cash on Delivery</h3>
                        <p>Pay when you receive your order</p>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('customer.orders') }}" class="btn-primary">
                    <i class="fas fa-list"></i>
                    View My Orders
                </a>
                <a href="{{ route('shop.index') }}" class="btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.order-success-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px 0;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
}

.success-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 60px 40px;
    text-align: center;
}

.success-icon {
    font-size: 5rem;
    color: #10b981;
    margin-bottom: 30px;
    animation: successPulse 2s ease-in-out infinite;
}

@keyframes successPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 20px;
}

.success-message {
    font-size: 1.1rem;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 40px;
}

.order-info {
    display: grid;
    gap: 25px;
    margin-bottom: 40px;
    text-align: left;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
    border-left: 4px solid #10b981;
}

.info-item i {
    font-size: 2rem;
    color: #10b981;
    width: 40px;
    text-align: center;
}

.info-content h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 5px;
}

.info-content p {
    color: #6b7280;
    font-size: 0.95rem;
    margin: 0;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 15px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    min-width: 180px;
    justify-content: center;
}

.btn-primary {
    background: #ff4757;
    color: white;
}

.btn-primary:hover {
    background: #ff3742;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 71, 87, 0.3);
}

.btn-secondary {
    background: white;
    color: #374151;
    border: 2px solid #e5e7eb;
}

.btn-secondary:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .success-content {
        padding: 40px 30px;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .success-icon {
        font-size: 4rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        max-width: 280px;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .info-item i {
        width: auto;
    }
}
</style>
@endsection
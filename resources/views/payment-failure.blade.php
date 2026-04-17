@extends('layout.main')

@section('hyasabicontentauncha')
<div class="payment-result-page">
    <div class="container">
        <div class="result-card failure-card">
            <div class="result-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            
            <h1 class="result-title">Payment Failed!</h1>
            <p class="result-message">{{ $message ?? 'Your payment could not be processed successfully.' }}</p>
            
            <div class="failure-info">
                <h3>What happened?</h3>
                <ul>
                    <li>Payment was cancelled by user</li>
                    <li>Insufficient balance in eSewa account</li>
                    <li>Network connection issue</li>
                    <li>Invalid payment credentials</li>
                </ul>
            </div>
            
            <div class="result-actions">
                <a href="{{ route('checkout') }}" class="btn btn-primary">
                    <i class="fas fa-redo"></i>
                    Try Again
                </a>
                <a href="{{ route('cart') }}" class="btn btn-secondary">
                    <i class="fas fa-shopping-cart"></i>
                    Back to Cart
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-tertiary">
                    <i class="fas fa-store"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.payment-result-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.container {
    max-width: 600px;
    width: 100%;
}

.result-card {
    background: white;
    border-radius: 20px;
    padding: 50px 40px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.failure-card .result-icon {
    color: #ef4444;
    font-size: 4rem;
    margin-bottom: 20px;
}

.result-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 10px;
}

.result-message {
    color: #6b7280;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.failure-info {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: left;
}

.failure-info h3 {
    color: #dc2626;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.failure-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.failure-info li {
    color: #7f1d1d;
    padding: 5px 0;
    position: relative;
    padding-left: 20px;
}

.failure-info li:before {
    content: "•";
    color: #dc2626;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.result-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #ef4444;
    color: white;
}

.btn-primary:hover {
    background: #dc2626;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #667eea;
    color: white;
}

.btn-secondary:hover {
    background: #5a67d8;
    transform: translateY(-2px);
}

.btn-tertiary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-tertiary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .result-card {
        padding: 40px 30px;
    }
    
    .result-title {
        font-size: 1.5rem;
    }
    
    .result-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
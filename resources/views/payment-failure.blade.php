@extends('layout.main')

@section('hyasabicontentauncha')
<div class="payment-result-page">
    <div class="container">
        <div class="result-card failure-card">
            <div class="result-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            
            <h1 class="result-title">❌ Payment Failed!</h1>
            <p class="result-message">{{ $message ?? 'Your payment could not be processed successfully.' }}</p>
            
            <div class="failure-info">
                <h3>💡 What might have happened?</h3>
                <ul>
                    <li>Payment was cancelled by user</li>
                    <li>Insufficient balance in eSewa account</li>
                    <li>Network connection issue during payment</li>
                    <li>Invalid payment credentials entered</li>
                    <li>eSewa service temporarily unavailable</li>
                    <li>Transaction timeout occurred</li>
                </ul>
            </div>

            <div class="help-section">
                <h3>🛠️ What can you do?</h3>
                <div class="help-steps">
                    <div class="step">
                        <span class="step-number">1</span>
                        <span class="step-text">Check your eSewa account balance</span>
                    </div>
                    <div class="step">
                        <span class="step-number">2</span>
                        <span class="step-text">Ensure stable internet connection</span>
                    </div>
                    <div class="step">
                        <span class="step-number">3</span>
                        <span class="step-text">Try the payment again</span>
                    </div>
                    <div class="step">
                        <span class="step-number">4</span>
                        <span class="step-text">Contact support if issue persists</span>
                    </div>
                </div>
            </div>
            
            <div class="result-actions">
                <a href="{{ route('checkout') }}" class="btn btn-primary">
                    <i class="fas fa-redo"></i>
                    Try Payment Again
                </a>
                <a href="{{ route('cart') }}" class="btn btn-secondary">
                    <i class="fas fa-shopping-cart"></i>
                    Back to Cart
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-tertiary">
                    <i class="fas fa-store"></i>
                    Continue Shopping
                </a>
                <a href="{{ route('contact') }}" class="btn btn-support">
                    <i class="fas fa-headset"></i>
                    Contact Support
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
    max-width: 700px;
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
    font-size: 5rem;
    margin-bottom: 20px;
}

.result-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 15px;
}

.result-message {
    color: #6b7280;
    font-size: 1.2rem;
    margin-bottom: 30px;
}

.failure-info {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    text-align: left;
}

.failure-info h3 {
    color: #dc2626;
    font-size: 1.2rem;
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
    padding: 8px 0;
    position: relative;
    padding-left: 25px;
    line-height: 1.5;
}

.failure-info li:before {
    content: "•";
    color: #dc2626;
    font-weight: bold;
    position: absolute;
    left: 0;
    font-size: 18px;
}

.help-section {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: left;
}

.help-section h3 {
    color: #0c4a6e;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.help-steps {
    display: grid;
    gap: 15px;
}

.step {
    display: flex;
    align-items: center;
    gap: 15px;
}

.step-number {
    background: #0ea5e9;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
    flex-shrink: 0;
}

.step-text {
    color: #0c4a6e;
    font-weight: 500;
}

.result-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    justify-content: center;
}

.btn {
    padding: 15px 25px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    font-size: 15px;
}

.btn-primary {
    background: #ef4444;
    color: white;
}

.btn-primary:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
}

.btn-secondary {
    background: #667eea;
    color: white;
}

.btn-secondary:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-tertiary {
    background: #10b981;
    color: white;
}

.btn-tertiary:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

.btn-support {
    background: #f59e0b;
    color: white;
}

.btn-support:hover {
    background: #d97706;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
}

@media (max-width: 768px) {
    .result-card {
        padding: 40px 30px;
    }
    
    .result-title {
        font-size: 2rem;
    }
    
    .result-actions {
        grid-template-columns: 1fr;
    }
    
    .help-steps {
        gap: 12px;
    }
    
    .step {
        gap: 12px;
    }
    
    .step-number {
        width: 25px;
        height: 25px;
        font-size: 12px;
    }
}
</style>
@endsection
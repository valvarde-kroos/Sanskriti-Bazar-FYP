@extends('layout.main')

@section('hyasabicontentauncha')
<div class="payment-result-page">
    <div class="container">
        <div class="result-card success-card">
            <div class="result-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="result-title">Payment Successful!</h1>
            <p class="result-message">Your payment has been processed successfully.</p>
            
            <div class="payment-details">
                <div class="detail-row">
                    <span class="detail-label">Amount Paid:</span>
                    <span class="detail-value">Rs. {{ number_format($amount ?? 0, 2) }}</span>
                </div>
                
                @if(isset($refId))
                <div class="detail-row">
                    <span class="detail-label">Reference ID:</span>
                    <span class="detail-value">{{ $refId }}</span>
                </div>
                @endif
                
                @if(isset($transactionId))
                <div class="detail-row">
                    <span class="detail-label">Transaction ID:</span>
                    <span class="detail-value">{{ $transactionId }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value success-status">SUCCESS</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ date('M d, Y - h:i A') }}</span>
                </div>
            </div>
            
            <div class="result-actions">
                <a href="{{ route('customer.orders') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i>
                    View My Orders
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.payment-result-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.success-card .result-icon {
    color: #10b981;
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

.payment-details {
    background: #f9fafb;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: left;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #6b7280;
    font-weight: 500;
}

.detail-value {
    color: #1f2937;
    font-weight: 600;
}

.success-status {
    color: #10b981;
    font-weight: 700;
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
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a67d8;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
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
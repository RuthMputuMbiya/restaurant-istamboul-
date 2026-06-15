<div class="plat-card">
    @if($popular ?? false)
        <div class="plat-badge popular">🔥 Populaire</div>
    @endif
    <a href="{{ route('client.menu.show', $plat->slug ?? $plat->id) }}" class="plat-link">
        <div class="plat-image">
            @if($plat->image)
                <img src="{{ asset('storage/' . $plat->image) }}" alt="{{ $plat->nom }}">
            @else
                <div class="image-placeholder">
                    <i class="fas fa-utensils"></i>
                </div>
            @endif
        </div>
        <div class="plat-info">
            <h3 class="plat-name">{{ $plat->nom }}</h3>
            <p class="plat-description">{{ Str::limit($plat->description ?? 'Délicieux plat maison', 50) }}</p>
            <div class="plat-footer">
                <span class="plat-price">{{ number_format($plat->prix, 0, ',', ' ') }} FC</span>
                <button class="add-to-cart-btn" 
                        data-id="{{ $plat->id }}"
                        data-name="{{ $plat->nom }}"
                        data-price="{{ $plat->prix }}">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </div>
        </div>
    </a>
</div>

<style>
.plat-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    position: relative;
}

.plat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.plat-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.plat-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 0.2rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 600;
    z-index: 2;
}

.plat-badge.popular {
    background: linear-gradient(135deg, #ff9f43, #ff6b6b);
    color: white;
}

.plat-image {
    height: 160px;
    overflow: hidden;
}

.plat-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.plat-card:hover .plat-image img {
    transform: scale(1.05);
}

.image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

.plat-info {
    padding: 1rem;
}

.plat-name {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.3rem;
}

.plat-description {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.8rem;
    line-height: 1.4;
}

.plat-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.plat-price {
    font-size: 1rem;
    font-weight: 800;
    color: #ff9f43;
}

.add-to-cart-btn {
    background: linear-gradient(135deg, #ff9f43, #ff6b6b);
    color: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-to-cart-btn:hover {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .plat-image {
        height: 140px;
    }
    
    .plat-name {
        font-size: 0.9rem;
    }
    
    .plat-price {
        font-size: 0.85rem;
    }
}
</style>
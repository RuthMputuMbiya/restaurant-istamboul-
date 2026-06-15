{{-- resources/views/layouts/partials/styles.blade.php --}}
<style>
    /* Gradients */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .bg-gradient-secondary {
        background: linear-gradient(135deg, #757f9a 0%, #d7dde8 100%);
    }
    
    /* Cards */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -10px rgba(0,0,0,0.15) !important;
    }
    
    /* Tables */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    /* Badges */
    .badge {
        font-weight: 500;
        padding: 6px 12px;
    }
    
    /* Buttons */
    .btn {
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
    
    /* Progress */
    .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .card, .table-responsive {
        animation: fadeIn 0.5s ease-out;
    }
    
.btn-edit-res {
    padding: 0.4rem 1rem;
    background: #e3f2fd;
    color: #2196f3;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-edit-res:hover {
    background: #bbdef5;
    color: #1976d2;
}
</style>
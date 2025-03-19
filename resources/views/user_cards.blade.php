<style>
    /* Common card styling */
    .card {
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        transition: transform 0.2s ease-in-out;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
    }
    .card-header {
        background-color: #f8f8f8;
        border-bottom: 1px solid #eee;
        padding: 12px 16px;
    }
    .card-header .card-title {
        font-size: 1.2rem;
        margin: 0;
        font-weight: 700;
    }
    .card-body {
        padding: 16px;
    }
    .card-body h4 {
        margin-bottom: 10px;
        font-size: 1.5rem;
        font-weight: 700;
    }
    .card-body p {
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    /* Status text and icons */
    .text-danger {
        color: #dc3545 !important;
    }
    .fw-bold {
        font-weight: 700;
    }

    /* Smaller adjustments for spacing/visual alignment */
    .mb-2 {
        margin-bottom: 0.5rem;
    }
    .me-2 {
        margin-right: 0.5rem;
    }
    .me-1 {
        margin-right: 0.25rem;
    }

    /* You can further customize .panel-success if needed */
    .panel-success {
        border-left: 4px solid #28a745;
    }
</style>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="row">
            <!-- Farmers -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Farmers') }}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2">{{ $data['total_farmers'] }}</h4>
                        <p class="text-muted">
                            <span class="text-danger fw-bold font-size-12 me-2">
                                <i class="glyphicon glyphicon-hourglass me-1 align-middle"></i>
                                {{ $data['pending_farmers'] }}
                            </span>
                            <a href="{{ admin_url('/seed-producers') }}">{{ __('View Details') }}</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Co-operatives -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card panel-success">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Co-operatives') }}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2">{{ $data['total_cooperatives'] }}</h4>
                        <p class="text-muted">
                            <span class="text-danger fw-bold font-size-12 me-2">
                                <i class="glyphicon glyphicon-hourglass me-1 align-middle"></i>
                                {{ $data['pending_cooperatives'] }}
                            </span>
                            <a href="{{ admin_url('/cooperatives') }}">{{ __('View Details') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right side -->
    <div class="col-lg-6 col-md-6">
        <div class="row">
            <!-- Input Providers -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card panel-success">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Input Providers') }}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2">{{ $data['total_input_providers'] }}</h4>
                        <p class="text-muted">
                            <span class="text-danger fw-bold font-size-12 me-2">
                                <i class="glyphicon glyphicon-hourglass me-1 align-middle"></i>
                                {{ $data['pending_input_providers'] }}
                            </span>
                            <a href="{{ admin_url('/individual-producers') }}">{{ __('View Details') }}</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vets and Paravets -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card panel-success">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Vets and Paravets') }}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2">{{ $data['total_vets'] }}</h4>
                        <p class="text-muted">
                            <span class="text-danger fw-bold font-size-12 me-2">
                                <i class="glyphicon glyphicon-hourglass me-1 align-middle"></i>
                                {{ $data['pending_vets'] }}
                            </span>
                            <a href="{{ admin_url('/vets') }}">{{ __('View Details') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        padding: 20px;
    }
</style>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Farmers')}}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2">{{ $data['total_farmers'] }}</h4>
                        <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i
                                    class="glyphicon glyphicon-hourglass me-1 align-middle"></i>{{ $data['pending_farmers'] }}</span><a
                                href="{{ admin_url('/seed-producers')}}">{{__('pending applications')}}</a></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card panel-success">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Co-operatives')}}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2"> {{ $data['total_cooperatives'] }}</h4>
                        <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i
                                    class="glyphicon glyphicon-hourglass me-1 align-middle"></i>{{ $data['pending_cooperatives'] }}</span><a
                                href="{{ admin_url('/cooperatives')}}">{{__('pending applications')}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card panel-success">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Input Providers')}}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2"> {{ $data['total_input_providers'] }}</h4>
                        <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i
                                    class="glyphicon glyphicon-hourglass me-1 align-middle"></i>{{ $data['pending_input_providers'] }}</span><a
                                href="{{ admin_url('/individual-producers')}}">{{__('pending applications')}}</a></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card panel-success">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Vets and Paravets')}}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2"> {{ $data['total_vets'] }}</h4>
                        <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i
                                    class="glyphicon glyphicon-hourglass me-1 align-middle"></i>{{ $data['pending_vets'] }}</span><a
                                href="{{ admin_url('/vets')}}">{{__('pending applications')}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

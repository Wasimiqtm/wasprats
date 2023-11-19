<div class="main-container">
        <div class="pcoded-content">
        <a class="btn btn-primary" id="addinvoice">Add New invoice</a>

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'invoice_id',
                                'job_id',
                                'Frequncy',
                                'Date',
                                'Total',
                            ]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



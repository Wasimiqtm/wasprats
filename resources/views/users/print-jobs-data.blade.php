<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container" id="printData">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        asdfsa
                                    </div>
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->


    @push('scripts')
        <script type="text/javascript" defer>
            $(document).ready(function() {
                printDiv('printData');
            });

            function printDiv(divName) {
                //var printContents = document.getElementsByClassName(divName).innerHTML;
                let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

                mywindow.document.write(`<html><head><title>Invoice</title>`);

                mywindow.document.write('</head><body >');
                mywindow.document.write(document.getElementById(divName).innerHTML);
                mywindow.document.write('</body></html>');

                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*!/

                mywindow.print();
                mywindow.close();

                return true;
            }
        </script>
    @endpush

</x-app-layout>

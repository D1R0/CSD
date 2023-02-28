<div class="app d-flex">
    <div class="body w-50">
        <div class="header ">
            <div class="activeRow text-center my-5">
                <h1 class="active text-center">
                    <div class="w-100 mx-auto d-flex justify-content-center">
                        <div class="w-100">

                            <h3>Nr. Concurent:</h3>
                            <h3 class="nrConc">1</h3>
                        </div>
                        <div class="w-100">a

                            <h1 class="numeConc">-</h1>
                            <h2 class="numePilot">-</h2>
                        </div>
                    </div>
                    <div class="w-100">
                        <h4 class="auto"></h4>
                        <h4 class="clasa"></h4>
                    </div>
                </h1>
            </div>
            <div class="nextOrPreview text-center">
                <button class="btn btn-warning m-2 back">Inapoi</button>
                <button class="btn btn-success m-2 next">Urmatorul</button>
            </div>
        </div>
        <hr>
        <div class="actionButtons text-center" id="stopwatch">
            <p id="time">00:00:00</p>
            <!--  <button class="btn btn-danger m-2 text-white p-4" id="stop">Stop</button> -->
            <button class="btn btn-success m-2 text-white p-4" id="start" onclick="start()">Start</button>
            <!--  <button class="btn btn-warning m-2 text-white p-4" id="reset">Reset</button> -->
        </div>
        <div class="text-center my-4">
            <h4>Export CSV</h4>
            <button class="btn btn-primary" onclick="exportCSV()">Export</button>
        </div>
    </div>
    <div class="tableSection w-50 m-0" style="overflow-y: auto; max-height:100vh">
        <table id="data-table"></table>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.1.0/papaparse.min.js"></script>
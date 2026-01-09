{{-- <div class="container">

    {{$cash_breakdown}}
    {{$cash_blotter}}

    <form id="add-cash-blotter">
        @csrf
    <div class="container">

        <div class="row">
            <div class="col-md-12">
               <div class="row">
                <div class="col-sm-3">
                    <label for="branch">Branch</label>
                    <div class="input-group" width="100%">

                        <select name="branch_id" class="form-control-sm form-control" name="" required>
                          <option value="{{$cash_blotter->sub_id}}" disabled selected>{{$cash_blotter->sub_name}}</option>
                          @foreach ($branches as $branch)
                              <option value="{{$branch->sub_id}}">{{$branch->sub_name}}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="branch">Transaction Date</label>
                    <div class="input-group">
                        <input type="date" name="transaction_date" disabled value="{{$cash_blotter->transaction_date}}" class="form-control form-control-sm" required>
                    </div>
                </div>
               </div>
            </div>
        </div>


        <div class="container pl-4">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="row">
                        <form id="add-cash-blotter" method="POST">
                        <table class="table table-sm cash-breakdown">
                            <thead>
                                <th class="table-header">Cash Breakdown</th>
                                <th class="table-header">Pcs.</th>
                                <th class="table-header">Total Amount</th>
                            </thead>
                            <tbody>
                                <tr class="cash-breakdown">
                                  <td>1000</td>
                                  <td><input type="number" name="onethousand" value="{{$cash_breakdown->onethousand_pesos}}" id="onethousand" class="form-control form-control-sm" required></td>
                                  <td id="onethousandtotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>500</td>
                                    <td><input type="number" name="fivehundred" value="{{$cash_breakdown->fivehundred_pesos}}" id="fivehundred" class="form-control form-control-sm" required></td>
                                    <td id="fivehundredtotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>200</td>
                                    <td><input type="number" name="twohundred" id="twohundred" class="form-control form-control-sm" required></td>
                                    <td id="twohundredtotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>100</td>
                                    <td><input type="number" name="onehundred" id="onehundred" class="form-control form-control-sm" required></td>
                                    <td id="onehundredtotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>50</td>
                                    <td><input type="number" name="fifty" id="fifty" class="form-control form-control-sm" required></td>
                                    <td id="fiftytotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>20</td>
                                    <td><input type="number" name="twenty" id="twenty" class="form-control form-control-sm" required></td>
                                    <td id="twentytotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>10</td>
                                    <td><input type="number" name="ten" id="ten" class="form-control form-control-sm" required></td>
                                    <td id="tentotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>5</td>
                                    <td><input type="number" name="five" id="five" class="form-control form-control-sm" required></td>
                                    <td id="fivetotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>1</td>
                                    <td><input type="number" name="one" id="one" class="form-control form-control-sm" required></td>
                                    <td id="onetotalamount">0</td>
                                </tr>
                                <tr class="cash-breakdown">
                                    <td>0.25</td>
                                    <td><input type="number" name="centavo" id="centavo" class="form-control form-control-sm" required></td>
                                    <td id="centavototalamount">0</td>
                                </tr>

                              </tbody>
                              <tfoot>
                                <tr>
                                    <td colspan="3"><p>Total Cash Count</p></td>
                                </tr>
                                <tr>

                                    <td class="text-right bg-primary" colspan="3" id="totalcashcount"><b>0</b></td>
                                </tr>
                              </tfoot>
                        </table>

                        </form>
                    </div>
                </div>
</div>
 --}}
<script>
    /*  $(document).ready(function(){
        $(document).on('change','#onethousand',function(){
            var val = 1000
            var pcs = $('#onethousand').val()
            $('#onethousandtotalamount').text(amountConverter(val*pcs))

        })
        $(document).on('change','#fivehundred',function(){
            var val = 500
            var pcs = $('#fivehundred').val()
            $('#fivehundredtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#twohundred',function(){
            var val = 200
            var pcs = $('#twohundred').val()
            $('#twohundredtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#onehundred',function(){
            var val = 100
            var pcs = $('#onehundred').val()
            $('#onehundredtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#fifty',function(){
            var val = 50
            var pcs = $('#fifty').val()
            $('#fiftytotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#twenty',function(){
            var val = 20
            var pcs = $('#twenty').val()
            $('#twentytotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#ten',function(){
            var val = 10
            var pcs = $('#ten').val()
            $('#tentotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#five',function(){
            var val = 5
            var pcs = $('#five').val()
            $('#fivetotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#one',function(){
            var val = 1
            var pcs = $('#one').val()
            $('#onetotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#centavo',function(){
            var val = .25
            var pcs = $('#centavo').val()
            $('#centavototalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })

        function amountConverter(amount) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',

            });

            return formatter.format(amount)
        }

        function totalCashCount() {
            var totalAmount = 0


            var onethousand = Number($('#onethousandtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var fivehundred = Number($('#fivehundredtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var twohundred = Number($('#twohundredtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var onehundred = Number($('#onehundredtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var fifty = Number($('#fiftytotalamount').text().replace(/[^0-9\.-]+/g,""))
            var twenty = Number($('#twentytotalamount').text().replace(/[^0-9\.-]+/g,""))
            var ten = Number($('#tentotalamount').text().replace(/[^0-9\.-]+/g,""))
            var five = Number($('#fivetotalamount').text().replace(/[^0-9\.-]+/g,""))
            var one = Number($('#onetotalamount').text().replace(/[^0-9\.-]+/g,""))
            var centavo = parseFloat(Number($('#centavototalamount').text().replace(/[^0-9\.-]+/g,"")))
            var total = onethousand+fivehundred+twohundred+onehundred+fifty+twenty+ten+five+one+centavo
            $('#totalcashcount').text(amountConverter(total))
        }

     }) */
</script>


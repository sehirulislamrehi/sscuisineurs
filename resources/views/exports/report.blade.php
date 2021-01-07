<table>
    <thead>
        <tr>
            <th>Reservation Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Adult</th>
            <th>Child Under 18 years old</th>
            <th>Child Under 12 years old</th>
            <th>Menu Item</th>
            <th>Menu Item Price</th>
            <th>Grand Total</th>
            <th>Grand Total After Discount</th>
            <th>Discount From</th>
            <th>Address</th>
            <th>City</th>
            <th>Country</th>
            <th>Message</th>
            <th>Code Number</th>
            <th>Payment Method</th>
            <th>Payment Type</th>
            <th>Payment Status</th>
            <th>Arrived</th>
        </tr>
    </thead>
    @php
       $total_amount_of_sale = 0;
        $total_adult = 0;
        $total_child_under_132 = 0;
        $total_child_under_120 = 0;
    @endphp
    <tbody>
        @foreach ($datas as $data)  
            <tr>
                <td>
                    {{ $data->reservation->booking_date }}
                </td>
                <td>
                    {{ $data->reservation->name }}
                </td>
                <td>
                    {{ $data->reservation->email }}
                </td>
                <td>
                    {{ (string)$data->reservation->phone }}
                </td>
            
                <td>
                    
                    {{ $data->reservation->adult }}
                </td>
                <td>
                    {{ $data->reservation->child_under_132_cm }}
                </td>
                <td>
                    {{ $data->reservation->child_under_120_cm }}
                </td>
                <td>
                    {{ $data->reservation->category->name }}
                </td>
                <td>
                    {{ $data->reservation->category_price }} BDT
                </td>
                <td>
                    {{ $data->amount }} BDT
                </td>
                <td>
                    {{ $data->discounted_amount ? $data->discounted_amount : 'No Discount in ' }} BDT
                </td>
                <td>
                    {{ $data->reservation->discount_type ? ( $data->reservation->discount_type == 'Brac' ? 'Brac Bank' : $data->reservation->discount_type  ) : 'N/A' }} @if( $data->reservation->discount_percent ) ({{ $data->reservation->discount_percent }}%) @endif
                </td>
                <td>
                    {{ $data->reservation->address }}
                </td>
                <td>
                    {{ $data->reservation->city }}
                </td>
                <td>
                    {{ $data->reservation->country }}
                </td>
                <td>
                    {{ $data->reservation->message }}
                </td>
                <td>
                    {{ $data->reservation->random }}
                </td>
                <td>
                    @if( $data->paid_by == 'Cash' )
                        On Spot Pay 
                    @else
                        Online Pay
                    @endif
                </td>
                <td>
                    {{ $data->reservation->payment_type ? $data->reservation->payment_type : 'N/A' }}
                </td>
                <td>
                    {{ $data->status }}
                </td>
                <td>
                    {{ $data->reservation->arrived ? 'Yes' : 'No' }}
                </td>
            </tr>
            @php
                
                
                $total_adult +=$data->reservation->adult;
                $total_child_under_132 +=$data->reservation->child_under_132_cm;
                $total_child_under_120 +=$data->reservation->child_under_120_cm;
                
                $total_amount_of_sale += $data->discounted_amount ? $data->discounted_amount : $data->amount ;
                
            @endphp
        @endforeach
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total Adult</th>
            <th>Total Child Under 18 years old</th>
            <th>Total Child Under 12 years old</th>
            <th></th>
            <th></th>
            <th>Total Amount of Sale</th>

        </tr>
    </thead>
    <tbody>       
        <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td>{{ $total_adult }}</td>
           <td>{{ $total_child_under_132 }}</td>
           <td>{{ $total_child_under_120 }}</td>
           <td></td>
           <td></td>
            <td>{{$total_amount_of_sale}} BDT</td>
            
        </tr>    
    </tbody>
</table>
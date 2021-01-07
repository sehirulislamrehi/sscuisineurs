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
                    {{ $data->booking_date }}
                </td>
                <td>
                    {{ $data->name }}
                </td>
                <td>
                    {{ $data->email }}
                </td>
                <td>
                    {{ (string)$data->phone }}
                </td>
            
                <td>
                    
                    {{ $data->adult }}
                </td>
                <td>
                    {{ $data->child_under_132_cm }}
                </td>
                <td>
                    {{ $data->child_under_120_cm }}
                </td>
                <td>
                    {{ $data->category->name }}
                </td>
                <td>
                    {{ $data->category_price }} BDT
                </td>
                <td>
                    {{ $data->bookingTransation->amount }} BDT
                </td>
                <td>
                    {{ $data->bookingTransation->discounted_amount ? $data->bookingTransation->discounted_amount : 'No Discount in ' }} BDT
                </td>
                <td>
                    {{ $data->discount_type ? ( $data->discount_type == 'Brac' ? 'Brac Bank' : $data->discount_type  ) : 'N/A' }} @if( $data->discount_percent ) ({{ $data->discount_percent }}%) @endif
                </td>
                <td>
                    {{ $data->address }}
                </td>
                <td>
                    {{ $data->city }}
                </td>
                <td>
                    {{ $data->country }}
                </td>
                <td>
                    {{ $data->message }}
                </td>
                <td>
                    {{ $data->random }}
                </td>
                <td>
                    @if( $data->bookingTransation->paid_by == 'Cash' )
                        On Spot Pay 
                    @else
                        Online Pay
                    @endif
                </td>
                <td>
                    @if($data->payment_type) {{ $data->payment_type }} @else N/A @endif
                </td>
                <td>
                    {{ $data->bookingTransation->status }}
                </td>
                <td>
                    {{ $data->arrived ? 'Yes' : 'No' }}
                </td>
            </tr>
            @php
                
                
                $total_adult +=$data->adult;
                $total_child_under_132 +=$data->child_under_132_cm;
                $total_child_under_120 +=$data->child_under_120_cm;
                
                $total_amount_of_sale += $data->bookingTransation->discounted_amount ? $data->bookingTransation->discounted_amount : $data->bookingTransation->amount ;
                
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
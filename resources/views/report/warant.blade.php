<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        @media print {
            .break {page-break-after: always;}
        }
        .break {page-break-after: always;}
        body { font-family: 'DejaVu Sans'; text-align: justify; }
        body, section.info { font-size: 11px; }
        .centered {
            text-align: center;
            align-content: center;
            margin: 0 auto;
        }

        .centered img {
            height: 60px;
        }
        .content {
            padding-top: 150px;
        }
        .dotted {
            min-width: 200px;
            border-bottom: 1px dotted #999999;
            display: inline-block;
            margin-right: 20px;
        }

        section {
            font-size: 10px;
        }

        .back-page {
            font-size: 12px !important;
            padding: 5px;
            line-height: 20px;
        }
        strong {
            border-bottom: 1px dotted #4a4a4a;
        }
    </style>
</head>
<body>
<div class="header centered">
    <img style="width: 13%; height: 13%;" src="{{ public_path('images/prokazi.jpg') }}" alt="Logo">
    <h2 style="margin-top: -1px !important;">EXPRESS SHIPING LIMITED </h2>
    <h3 style="margin-top: -10px !important;">IMPREST WARRANT #{{ $imprest->imprest_number }}</h3>
    <br>
    <br>
</div>
<div class="content">
    <em>(Please read conditions on issue of Imprests on reverse)</em>
    <br>
    <br>
    <section class="info">
        <div style="padding: 5px; text-transform: uppercase;">
            <div style="width: 40%; display: inline-block;">1. Name of applicant: <strong>{{ $imprest->Description }}</strong></div>
        </div>
        <div style="padding: 5px; text-transform: uppercase;">
            <div style="width: 40%; display: inline-block;">Personal Number: <strong>{{ isset($imprest->applicant_id)?:" " }}</strong></div>
            <span style="margin-left: 100px;">Department: <strong>{{ $imprest->name }}</strong></span>
        </div>
        <div style="padding: 5px; text-transform: uppercase;">
            I apply for Standing/Temporary/Special * Imprests of Kshs <strong>{{ number_format($imprest->advance_amount, 2) }}</strong>
        </div>
        <div style="padding: 5px; text-transform: uppercase;">
            in words: <strong>KENYAN SHILLINGS  {{ strtoupper(numberToWords($imprest->advance_amount)) }} CENTS ONLY</strong>
        </div>
        <div style="padding: 5px;">for the following purposes</div>
        <div style="padding: 5px;">Nature of Duty: <strong>{{ $imprest->nature_of_duty }}</strong></div>
        <br><br>
        <br><br>
        <!-- <div style="width: 80%; margin: 0 auto;">
            <div style="width: 50%; float: left;">
                <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                <div style="text-align: center;">Date</div>
            </div>
            <div style="width: 50%; float: right;">
                <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                <div style="text-align: center;">Signature of applicant</div>
            </div>
                    <br><br>
        </div>
             <br><br> -->
    </section>
<!--     <section>
        <br>
        <br>
        <p>
            2. (i) I hereby authorize the request and confirm that funds are available to meet the expenses and the
            amount is realistic and a proper charge against public funds.
            <br><br>
            (ii) I certify that the applicant does not have any outstanding imprest.
        </p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="width: 80%; margin: 0 auto;">
            <div style="width: 50%; float: left;">
                <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                <div style="text-align: center;">Date</div>
            </div>
            <div style="width: 50%; float: right;">
                <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                <div style="text-align: center;">Managing Director</div>
            </div>
        </div>
    </section>
secti on>
       <br>
        <br>
        <p>
            3. I certify that the imprest has been noted in the imprest Register Folio No..........................
            and the applicant does not have any outstanding Imprest.
        </p>

        <br>
        <br>
        <br>
        <br>
        <div>
            <div style="width: 80%; margin: 0 auto;">
                <div style="width: 50%; float: left;">
                    <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                    <div style="text-align: center;">Date</div>
                </div>
                <div style="width: 50%; float: right;">
                    <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                    <div style="text-align: center;">General Manager, Finance & Administration</div>
                </div>
            </div>
        </div>
    </section> 

    <section>
        <br>
        <p>
            4. I acknowledge receipt of an imprest of <strong>Ksh. {{ $imprest->advance_amount }}</strong> which I undertake to account for in full on or before the <strong>{{ Carbon\Carbon::parse($imprest->due_date)->format('d F Y') }}</strong> In the event of my failure to account for the imprest within 7 days following return from official duty, the Accounting Officer will recover that amount in full from my salary in addition to any other action that may be preferred against me.
        </p>
        <br><br>
        <br><br>
        <div style="width: 80%; margin: 0 auto;">
            <div style="width: 50%; float: left;">
                <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                <div style="text-align: center;">Date</div>
            </div>
            <div style="width: 50%; float: right;">
                <div style="text-align: center; margin: 0 30px" class="dotted"></div>
                <div style="text-align: center;">Imprest Holder</div>
            </div>
        </div>
    </section> -->
    <br><br>
    <section>
        <table style="width: 95%; margin: 0 auto;" cellspacing="0" cellpadding="5">
            <tr>
                <th style="border: 1px solid #999999">Account No.</th>
                {{--<th style="border: 1px solid #999999">Dept. Voucher No.</th>--}}
                <th style="border: 1px solid #999999">Station</th>
                {{--<th style="border: 1px solid #999999">C.B. Vr. No.</th>--}}
                <th style="border: 1px solid #999999">Date</th>
                <th style="border: 1px solid #999999">Kshs.</th>
                <th style="border: 1px solid #999999">Cts.</th>
            </tr>
            <tr>
                <td style="border: 1px solid #999999; text-align: center">{{ $imprest->applicant_id }}</td>
{{--                <td style="border: 1px solid #999999; text-align: center">{{ $imprest->voucher_number }}</td>--}}
                <td style="border: 1px solid #999999; text-align: center">{{ $imprest->name }}</td>
{{--                <td style="border: 1px solid #999999; text-align: center">{{ $imprest->CB_number }}</td>--}}
                <td style="border: 1px solid #999999; text-align: center">{{ Carbon\Carbon::parse($imprest->CB_date)->format('d F Y') }}</td>
                <td style="border: 1px solid #999999; text-align: center">{{ number_format($imprest->advance_amount) }}</td>
                <td style="border: 1px solid #999999; text-align: center">00</td>
            </tr>
        </table>
    </section>

<!--     <section>
        <div>* Delete as applicable</div>
        <div>Original copy for use by the Accounts Department.</div>
        <div>Duplicate copy to be retained by the Imprest Section.</div>
        <div>Triplicate copy to be used by the applicant to account for the imprest.</div>
        {{--<div>Quadruplicate copy to remain in the pad.</div>--}}
    </section>
</div>
<span class="break"></span>

<div class="back-page">
    <div class="header centered">
        <em>Conditions of issue of Imprests</em>
    </div>
    <div class="content">
        <ol>
            <li>This Warrant must not bt authorised unless and until all previous imprests have been surrendered and fully accounted for.</li>
            <li>This Warrant should not be approved unless the chargeable items has/have sufficient funds to meet the resultant expenditure.</li>
            <li>Imprest must never be treated as loans or personal advances and where on has failed to account for an imprest on due date his entire salary must be utilized until the whole debt is liquidated.</li>
            <li>All temporary imprests must be surrendered or accounted for within 7 days, after return to duty station.</li>
            <li>Imprests will be issued and accounted for in accordance with regulations in force from time to time.</li>
            {{--<li>In case of imprests issued fro overseas travel, imprest holder should within 48 hours of their return complete the certificate given here below to facilitate calculation of their actual entitlement based on per diem rates.--}}
            <li style="text-align:justify;">
                <br>
                <br>
                <div>I certify that I was on official duty in ............................................................................ for ............................................... days from ......................................................... to ............................................................... as supported by departure/arrival dates in my passport No ...........................................................................</div>
                <br>
                Date: ..........................................................
                <br>
                <br>
                <br>
                Imprest Holder: ..............................................................
            </li>
            <li>
                Where an officer has cash imprest, he/she should complete the certificate appended here below:
                <br>
                <br>
                <div>I certify the expenditure incurred was for official duty as approved ............................................................................ for ................................................</div>
                <br>
                <br>
                Imprest Holder: ..............................................................
                <br>
                <br>
                <div>I certify that the above information is correct.</div>
                <br>
                Date: ..............................................................
                <br>
                <br>
                Head of Department: ..............................................................
            </li>
        </ol>
    </div>
</div> -->
</body>
</html>

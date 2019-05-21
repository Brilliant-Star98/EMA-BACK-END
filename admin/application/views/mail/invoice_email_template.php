<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div class="invoice-box" style="
		max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;">
        <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left; margin-bottom: 150px">
            <tr class="top">
                <td colspan="2" style="padding: 5px; vertical-align: top;padding-bottom: 20px;">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
                        <tr>
                            <td class="title" style="padding: 5px; vertical-align: top;text-align:center;">
                                <img src="<?php echo $logo_url; ?>" style="width:100%; max-width:300px;max-height: 120px;">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


			 <tr class="top">
                <td colspan="2" style="padding: 5px; vertical-align: top;">
                    <table style="width: 100%;line-height: inherit;text-align: left;max-width: 800px;">
                        <tr>
                            <td class="title" style="padding: 5px; vertical-align: top;">
							<h1>Invoice</h1>
                            </td>

                            <td style="text-align:right; padding: 5px; vertical-align: top;">
                                Invoice #: <?= date('Y') ?>-INV<?= $paymentData->id ?><br>
                                Created : <?= date("F j, Y", strtotime($paymentData->transaction_date)) ?><br>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2"  style="padding: 5px; vertical-align: top;">
                    <table style="width: 100%;line-height: inherit;text-align: left;margin-top: 50px;margin-bottom: 50px;">
                        <tr>
                            <td  style="padding: 5px; vertical-align: top;">
                                <?= $userData->fname; ?> <?= $userData->lname ?><br>
                                <?= $userData->full_address; ?>, <?= $userData->street; ?><br>
                                <?= $userData->court; ?>, <?= $userData->country; ?>
                            </td>

                            <td style="text-align:  right;padding: 5px; vertical-align: top;">
                                +<?= $userData->country_code; ?>-<?= $userData->mobile; ?><br>
                                <?= $userData->email; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


            <tr class="heading">
                <td  style="padding: 5px; vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    Payment Method
                </td>
				<td style="text-align:right;padding: 5px; vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
				<?= $paymentData->paytment_method ?>
				</td>
            </tr>

			 <tr class="item">
                <td  style="padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    Transaction Id
                </td>

                <td style="text-align:  right;padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
				<?= $paymentData->transaction_id ?>
                </td>
            </tr>

			 <tr class="item">
                <td  style="padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    Amount
                </td>

                <td style="text-align:  right;padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
				 KES<?= $paymentData->amount ?>
                </td>
            </tr>




            <tr class="heading">
                <td  style="padding: 5px; vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    <?= $billDetails[0]->bill_title ?> Bill
                </td>
				<td style="padding: 5px; vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;"></td>
            </tr>


            <tr class="item">
                <td  style="padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    Bill Month
                </td>

                <td style="text-align:  right;padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
				<?= date("F Y", strtotime($billDetails[0]->bill_month)) ?>
                </td>
            </tr>

            <tr class="item">
                <td  style="padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    Total Unit
                </td>

                <td style="text-align:  right;padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    <?= $billDetails[0]->unit ?>
                </td>
            </tr>

            <tr class="item last">
                <td  style="padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    Bill Amount
                </td>

                <td style="text-align:  right;padding: 5px; vertical-align: top;border-bottom: 1px solid #eee;">
                    KES<?= $billDetails[0]->bill_amount ?>
                </td>
            </tr>

            <tr class="item last">
                <td  style="padding: 5px; vertical-align: top;border-bottom: none;">
                    Late Fee
                </td>

                <td style="text-align:  right;padding: 5px; vertical-align: top;border-bottom: none;">
                    KES<?= $billDetails[0]->late_fee ?>
                </td>
            </tr>

            <tr class="total">
                <td  style="padding: 5px; vertical-align: top;border-top: 2px solid #eee; font-weight: bold;"></td>

                <td style="text-align: right;padding: 5px; vertical-align: top;border-top: 2px solid #eee; font-weight: bold;">
                   Total: KES<?= $billDetails[0]->total_amount ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

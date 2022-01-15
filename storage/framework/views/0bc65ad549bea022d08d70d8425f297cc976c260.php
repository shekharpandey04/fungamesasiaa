<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form info</title>
    <style>
        table tr td {
            padding: 10px;
            align-content: center;
            font-weight: 500;
            font-size: 17px;
            font-family: "Courier New", Courier, monospace;
        }

        #go_center {
            align-content: center;

        }

        body a {
            color: darkgreen;
            font-weight: 500;
            text-decoration: none;
        }

        body a:hover {
            text-decoration: underline;

        }
    </style>
</head>

<body style="background: #f8f9fa;padding:1em;">

    <table border="1" align="center" style="width: 66.66666667%;">
        <tr>
            <td colspan="2" align="center">
                <h2>New Enquiry</h2>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <h2>From Fun Games Asiaa</h2>
            </td>
        </tr>
        <tr>
            <td>Name</td>
            <td><?php echo e($valid_email->name); ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo e($valid_email->email); ?></td>
        </tr>
        <tr>
            <td>Mobile Number</td>
            <td><?php echo e($valid_email->mobile_no); ?></td>
        </tr>
        <tr>
            <td>Location</td>
            <td><?php echo e($valid_email->location); ?></td>
        </tr>
        <tr>
            <td>Message</td>
            <td><?php echo e($valid_email->message); ?></td>
        </tr>
    </table>

    <h4 align="center">This Mail Send from Fun Games Asiaa From Contact For</h4>

    <div class="container text-center">
        <!-- <a align="center" id="go_center" href="http://www.fungamesasia.net"> Get More Information Click Here</a> -->
        <div class="copyrights">
            <p align="center"> &copy; <?php echo e($date = date('Y')); ?> Fun Games Asiaa | All Rights Reserved | Get More Information Click Here <a href="https://fungameasiaa.com/" target="_blank"> Fun Games Asiaa</a></p>
        </div>
    </div>

</body>

</html>
<?php /**PATH /var/www/html/fungames_asiaa/resources/views/MailView/SendContactInfo.blade.php ENDPATH**/ ?>
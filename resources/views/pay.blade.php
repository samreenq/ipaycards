<html>
<head>
    <script src="https://ap-gateway.mastercard.com/checkout/version/51/checkout.js"
            data-error="errorCallback"
            data-cancel="cancelCallback"
            data-complete="http://[your domain]/receiptPage">
    </script>

    <script type="text/javascript">
        function errorCallback(error) {
            console.log(JSON.stringify(error));
        }
        function cancelCallback() {
            console.log('Payment cancelled');
        }

        Checkout.configure({
            merchant:'TEST222204083001',
            order: {
                amount: 50,
                currency: 'USD',
                description: 'Ordered goods',
                id: '8504'
            },
            session: {
                id: 'SESSION0002504595729M0342342M56'
            },
            interaction: {
                merchant: {
                    name: 'Your merchant name',
                    address: {
                        line1: '200 Sample St',
                        line2: '1234 Example Town'
                    }
                }
            }
        });

        Checkout.showLightbox()

    </script>
</head>
<body>
</body>
</html>
	<div id="amazon-root"></div>
	<script type="text/javascript">

	  window.onAmazonLoginReady = function() {
	    amazon.Login.setClientId('amzn1.application-oa2-client.3032012dedb74c53bcf3e0d3e140e44e');

	   	

	  };
	  (function(d) {
	    var a = d.createElement('script'); a.type = 'text/javascript';
	    a.async = true; a.id = 'amazon-login-sdk';
	    a.src = 'https://api-cdn.amazon.com/sdk/login1.js';
	    d.getElementById('amazon-root').appendChild(a);
	  })(document);



	</script>

<script type="text/javascript">

  document.getElementById('LoginWithAmazon').onclick = function() {
    options = { scope : 'profile' };
    amazon.Login.authorize(options, 'https://www.example.com/handle_login.php');
    return false;
  };

</script>
<a href="#" id="LoginWithAmazon">
  <img border="0" alt="Login with Amazon"
    src="https://images-na.ssl-images-amazon.com/images/G/01/lwa/btnLWA_gold_156x32.png"
    width="156" height="32" />
</a>
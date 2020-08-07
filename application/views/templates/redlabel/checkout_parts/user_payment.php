<style>
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;
  height: 40px;
  padding: 10px 12px;
  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;
  border: 1px solid #d1d1d1;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>
	
<script src="https://js.stripe.com/v3/"></script>

<section class="initiate_payment section_padding">
    <div class="container">   
        <div class="col-md-7 margin_auto hello">   
			<form action="<?php echo base_url('payment/initiate_payment')?>" method="post" id="payment-form">
			  <div class="form-row">
         
          <input type="hidden" name="full_name" value="<?=(isset($_POST['full_name']))?$_POST['full_name']:''?>">
          <input type="hidden" name="address" value="<?=(isset($_POST['address']))?$_POST['address']:''?>">
          <input type="hidden" name="mobile" value="<?=(isset($_POST['mobile']))?$_POST['mobile']:''?>">
          <input type="hidden" name="country" value="<?=(isset($_POST['country']))?$_POST['country']:''?>">
          <input type="hidden" name="state" value="<?=(isset($_POST['state']))?$_POST['state']:''?>">
          <input type="hidden" name="city" value="<?=(isset($_POST['city']))?$_POST['city']:''?>">
          <input type="hidden" name="postal_code" value="<?=(isset($_POST['postal_code']))?$_POST['postal_code']:''?>">
				<label for="card-element">
				  Credit or debit card
				</label>
				<div id="card-element">
				  <!-- A Stripe Element will be inserted here. -->
				</div>

				<!-- Used to display form errors. -->
				<div id="card-errors" role="alert"></div>
			  </div>

			  <button>Paynow</button>
			</form>
        </div>  
    </div>  
</section>


<script>
// Create a Stripe client.
var stripe = Stripe('<?=STRIPE_KEY?>');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>
<template>
  <div class="py-5">
    <stripe-checkout
      ref="checkoutRef"
      :pk="publishableKey"
      :sessionId="sessionId"
    />
    <button @click="submit">Pay now!</button>
  </div>
</template>

<script>
import { StripeCheckout } from '@vue-stripe/vue-stripe';
import axios from 'axios';
export default {
  components: {
    StripeCheckout,
  },
  data () {
    return {
        publishableKey: 'pk_test_51NheOECZ7TgLSifQXQNFpmd97gGnR5AVjn7K1Yu9OXOZqwFOjL5TomUGbSVvNebH8BBNrn7UhJmGVMPTYaEdbQYS00x4VSEXoe',
        sessionId: null,
    };
  },
  mounted() {
    this.getSession();
  },
  methods: {
    async getSession() {
        await axios.get('get-session').then((response) => {
            console.log(response);
            this.sessionId = response.data.id;
        }).catch((error) => {
            console.log("   Checkout Page Error: ", error);
        });
    },
    submit () {
      // You will be redirected to Stripe's secure checkout page
      this.$refs.checkoutRef.redirectToCheckout();
    },
  },
};
</script>
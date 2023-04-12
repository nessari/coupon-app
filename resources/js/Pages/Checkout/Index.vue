<template>
    <Head title="Checkout" />
    <div
        class="lg:w-2/3 w-full mx-auto mt-8 mb-auto place-items-center min-h-screen"
    >
        <template v-if="isConfirmed">
            <h2 class="text-lg font-semibold italic m-8">
                Thank you for your order.
            </h2>
            <Confirmation :order="order" />
        </template>

        <template v-else>
            <h2 class="text-4xl font-semibold text-gray-800">
                Secure Checkout
            </h2>
            <!-- Customer details -->
            <form id="payment-form" @submit.prevent="processPayment">
                <div class="flex flex-wrap -mx-2 mt-8">
                    <div class="p-2 w-1/2">
                        <div class="relative">
                            <label
                                for="name"
                                class="leading-7 text-sm text-gray-600"
                                >Name</label
                            >
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="w-full bg-gray-100 rounded border border-gray-300 focus:border-gray-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                v-model="form.name"
                                :disabled="paymentProcessing"
                            />
                            <span
                                class="flex text-md text-red-600 mt-2"
                                v-if="errors.name"
                            >
                                {{ errors.name[0] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-2 w-1/2">
                        <div class="relative">
                            <label
                                for="email"
                                class="leading-7 text-sm text-gray-600"
                                >Email Address</label
                            >
                            <input
                                type="text"
                                id="email"
                                name="email"
                                class="w-full bg-gray-100 rounded border border-gray-300 focus:border-gray-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                v-model="form.email"
                                :disabled="paymentProcessing"
                            />
                            <span
                                class="flex text-md text-red-600 mt-2"
                                v-if="errors.email"
                            >
                                {{ errors.email[0] }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-2 mt-4">
                    <div class="p-2 w-1/3">
                        <div class="relative">
                            <label
                                for="address"
                                class="leading-7 text-sm text-gray-600"
                                >Street Address</label
                            >
                            <input
                                type="text"
                                id="address"
                                name="address"
                                class="w-full bg-gray-100 rounded border border-gray-300 focus:border-gray-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                v-model="form.address"
                                :disabled="paymentProcessing"
                            />
                            <span
                                class="flex text-md text-red-600 mt-2"
                                v-if="errors.address"
                            >
                                {{ errors.address[0] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-2 w-1/3">
                        <div class="relative">
                            <label
                                for="city"
                                class="leading-7 text-sm text-gray-600"
                                >City</label
                            >
                            <input
                                type="text"
                                id="city"
                                name="city"
                                class="w-full bg-gray-100 rounded border border-gray-300 focus:border-gray-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                v-model="form.city"
                                :disabled="paymentProcessing"
                            />
                            <span
                                class="flex text-md text-red-600 mt-2"
                                v-if="errors.city"
                            >
                                {{ errors.city[0] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-2 w-1/3">
                        <div class="relative">
                            <label
                                for="zip_code"
                                class="leading-7 text-sm text-gray-600"
                                >Zip Code</label
                            >
                            <input
                                type="text"
                                id="zip_code"
                                name="zip_code"
                                class="w-full bg-gray-100 rounded border border-gray-300 focus:border-gray-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                v-model="form.zip_code"
                                :disabled="paymentProcessing"
                            />
                            <span
                                class="flex text-md text-red-600 mt-2"
                                v-if="errors.zip_code"
                            >
                                {{ errors.zip_code[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Card details -->
                <div class="flex flex-wrap -mx-2 mt-4">
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label
                                for="card-element"
                                class="leading-7 text-sm text-gray-600"
                                >Credit Card Info</label
                            >
                            <div
                                id="card-element"
                                class="w-full h-11 p-3 bg-gray-100 rounded border border-gray-300 focus:border-gray-500 text-base outline-none text-gray-700 leading-8 transition-colors duration-200 ease-in-out"
                            ></div>
                            <p
                                id="card-error"
                                role="alert"
                                class="mt-3 text-base text-red-600"
                            >
                                {{ cardError }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <YellowButton
                        class="flex mx-auto border-0 py-2 px-8 focus:outline-none text-lg"
                        :class="{ 'opacity-75 cursor-not-allowed': disabled }"
                        as="submit"
                        :disabled="disabled"
                        v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
                    ></YellowButton>
                </div>
            </form>
        </template>
    </div>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import Confirmation from "../../Shared/Confirmation";
import YellowButton from "../../Shared/YellowButton";

export default {
    components: { Confirmation, YellowButton },
    props: { cartTotal: String },
    data() {
        return {
            cardElement: {},
            cardError: "",
            disabled: true,
            elements: {},
            errors: [],
            form: {
                name: "",
                email: "",
                address: "",
                city: "",
                zip_code: "",
            },
            isConfirmed: false,
            paymentProcessing: false,
            order: {},
            stripe: {},
            style: {
                base: {
                    fontFamily: "Montserrat, sans-serif",
                    fontSmoothing: "antialiased",
                    fontSize: "16px",
                },
                invalid: {
                    fontFamily: "Montserrat, sans-serif",
                    color: "#DC2626",
                    iconColor: "#DC2626",
                },
            },
        };
    },
    mounted() {
        this.iniStripe();
    },
    methods: {
        async iniStripe() {
            this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY);
            this.elements = this.stripe.elements();
            this.cardElement = this.elements.create("card", {
                style: this.style,
                hidePostalCode: true,
            });
            this.cardElement.mount("#card-element");
            this.cardElement.on("change", (event) => {
                this.disabled = false;
                this.cardError = event.error ? event.error.message : "";
            });
        },
        async processPayment() {
            this.paymentProcessing = true;
            this.disabled = true;
            const { paymentMethod, error } =
                await this.stripe.createPaymentMethod({
                    type: "card",
                    card: this.cardElement,
                    billing_details: {
                        name: this.form.name,
                        email: this.form.email,
                        address: {
                            line1: this.form.address,
                            city: this.form.city,
                            postal_code: this.form.zip_code,
                        },
                    },
                });
            if (error) {
                this.paymentProcessing = true;
                if (error.param === "billing_details[name]") {
                    this.cardError = "The name is required!";
                } else if (error.param === "billing_details[email]") {
                    this.cardError = "The email is required!";
                }
            } else {
                this.paymentProcessing = false;
                this.form.payment_method_id = paymentMethod.id;
                this.form.amount = this.cartTotal;
                this.checkout();
            }
        },
        checkout() {
            axios
                .post("/checkout", this.form)
                .then((response) => {
                    console.log(response);
                    console.log(response.data.order);
                    this.order = response.data.order;
                    this.isConfirmed = true;
                    Toast.fire({
                        icon: "success",
                        title: "Your payment has been successful!",
                    });
                })
                .catch((err) => {
                    if (err.response.status === 422) {
                        this.errors = err.response.data.errors;
                    } else {
                        this.errors = [];
                        err.response.status === 500
                            ? (this.cardError = err.response.data.errors)
                            : err.response.data.message;
                    }
                });
        },
    },
};
</script>

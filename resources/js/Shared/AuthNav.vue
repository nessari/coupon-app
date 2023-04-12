<template>
    <nav>
        <ul class="flex items-center space-x-6">
            <li>
                <NavLink href="/" :active="$page.component === 'Coupons'" class="px-10 font-bold text-yellow-500 text-lg"
                    >Coupons</NavLink
                >
            </li>
            <li>
                <NavLink
                    :href="route('cart-index')"
                    as="button"
                    class="text-yellow-500 text-6xl relative flex"
                >
                    <span
                        class="absolute inset-0 object-right-top -mr-6"
                        v-if="$page.props.cartCount > 0"
                    >
                        <div
                            class="absolute leading-tight rounded-full bg-red-700 p-1 w-6 h-6 -top-3 right-2 text-white text-sm flex justify-center items-center text-center font-mono"
                        >
                            {{ $page.props.cartCount }}
                        </div>
                    </span>
                    <Icon name="cart" class="w-7 h-7 fill-current"></Icon>
                </NavLink>
            </li>
            <li>
                <NavLink :href="route('wishlist')" :active="$page.component === 'User/Saved'" class="text-yellow-500 text-lg"
                    >Saved</NavLink
                >
            </li>
            <li>
                <NavLink :href="route('orders-index')" :active="$page.component === 'User/Orders'" class="text-yellow-500 text-lg"
                    >Orders</NavLink
                >
            </li>
            <li>
                <YellowButton
                    href="/logout"
                    method="post"
                    as="href"
                    >Logout</YellowButton
                >
            </li>
        </ul>
    </nav>
</template>

<script>
import NavLink from "./NavLink";
import YellowButton from "./YellowButton"

export default {
    components: { NavLink, YellowButton },
};
</script>

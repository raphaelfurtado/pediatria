<div x-data="{ show: false }" class="relative">
    <input type="password" x-bind:type="show ? 'text' : 'password'" {{ $attributes->merge(['class' => 'pr-11']) }}>
    <button type="button" tabindex="-1" @click="show = ! show"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-primary transition-colors"
        x-bind:title="show ? 'Ocultar senha' : 'Mostrar senha'">
        <span class="material-symbols-outlined text-lg" x-text="show ? 'visibility_off' : 'visibility'"></span>
    </button>
</div>

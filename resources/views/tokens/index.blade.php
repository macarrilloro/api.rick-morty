<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            API Access Tokens
        </h2>
    </x-slot>
    <div id="app">
        <x-container class="py-8">
            {{-- Formulario para crear tokens --}}
            <x-form-section class="mb-12">
                <x-slot name="title">
                    API Access Tokens
                </x-slot>
                <x-slot name="description">
                    Acá podrás crear nuevos Access Tokens
                </x-slot>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-5">
                        <div v-if="createForm.errors.length > 0" class="mb-4 bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong class="font-bold">Error. </strong>
                            <span>Hubo un error al guardar los datos</span>
                            <ul>
                                <li v-for="error in createForm.errors">@{{error}}</li>
                            </ul>
                        </div>
                        <div>
                            <x-input-label>
                                Nombre
                            </x-input-label>
                            <x-text-input v-model="createForm.name" type="text" class="w-full mt-1" />
                        </div>
                        <div v-if="scopes.length > 0">
                            <x-input-label>
                                Scopes
                            </x-input-label>
                            <div v-for="scope in scopes">
                                <x-input-label>
                                    <input type="checkbox" name="scopes" :value="scope.id" v-model="createForm.scopes"/>
                                    @{{scope.id}}
                                </x-input-label> 
                            </div>
                        </div>
                    </div>
                </div>
                <x-slot name="actions">
                    <x-primary-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        Crear
                    </x-primary-button>
                </x-slot>
            </x-form-section>
            {{-- Listado de tokens --}}
            <x-form-section v-if="tokens.length > 0">
                <x-slot name="title">
                    Listado de API Access Tokens
                </x-slot>
                <x-slot name="description">
                    Estos son los API Access Token que has agregado
                </x-slot>
                <div>
                    <table class="text-gray-300">
                        <thead class="border-b border-gray-700">
                            <tr class="text-left">
                                <th class="py-2 w-full">Nombre</th>
                                <th class="py-2">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 text-gray-200">
                            <tr v-for="token in tokens">
                                <td class="py-2">
                                    @{{token.name}}
                                </td>
                                <td class="py-2 flex divide-x divide-gray-700">
                                    <a v-on:click="show(token)"
                                    class="pr-2 hover:text-green-600 font-semibold cursor-pointer">
                                        Ver
                                    </a>
                                    <a v-on:click="revoke(token)"
                                    class="pl-2 hover:text-red-600 font-semibold cursor-pointer">
                                        Revocar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-form-section>
        </x-container>
        <x-dialog-modal modal="showToken.open">
            <x-slot name="title">
                Información del token
            </x-slot>
            <x-slot name="content">
                <div class="space-y-2 overflow-auto">
                    <span class="font-semibold">Access Token: </span>
                    <span v-text="showToken.id"></span>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button v-on:click="showToken.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cerrar</button>
            </x-slot>
        </x-dialog-modal>
    </div>
    @push('js')
    <script>
        const { createApp } = Vue;
        createApp({
            data() {
                return{
                    tokens:[],
                    scopes:[],
                    showToken:{
                        open: false,
                        id: null,

                    },
                    createForm:{
                        name: null,
                        errors: [],
                        disabled: false,
                        scopes:[],
                    },
                }
            },
            mounted(){
                this.getTokens();
                this.getScopes();
            },
            methods:{
                getTokens(){
                    axios.get('/oauth/personal-access-tokens')
                    .then(response => {
                        this.tokens = response.data;
                    })
                },
                getScopes(){
                    axios.get('/oauth/scopes')
                    .then(response => {
                        this.scopes = response.data;
                    })
                },
                show(token){
                    this.showToken.open = true;
                    this.showToken.id = token.id;
                },
                store(){
                    this.createForm.disabled = true;
                    axios.post('/oauth/personal-access-tokens',this.createForm)
                    .then(response => {
                        this.createForm.name = null;
                        this.createForm.errors = [];
                        this.createForm.scopes = [];
                        this.createForm.disabled = false;
                        this.getTokens();
                    })
                    .catch(error =>{
                        this.createForm.errors = Object.values(error.response.data.errors).flat();
                        this.createForm.disabled = false;
                    });
                },
                revoke(token){
                    Swal.fire({
                            title: '¿Esta seguro?',
                            text: "Esto no se podrá revertir",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, revocar',
                            cancelButtonText: 'Cancelar'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            axios.delete('/oauth/personal-access-tokens/'+token.id)
                            .then(response => {
                                Swal.fire(
                                    'Eliminado!',
                                    'El registro se revocó correctamente.',
                                    'success'
                                );
                                this.getTokens();
                            })
                        }
                    });
                },
            },
        }).mount('#app');
    </script>
    @endpush
</x-app-layout>
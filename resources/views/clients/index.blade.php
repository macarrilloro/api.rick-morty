<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Clientes
        </h2>
    </x-slot>
    <div id="app">
        <x-container class="py-8">
            {{-- Formulario para crear clientes --}}
            <x-form-section class="mb-12">
                <x-slot name="title">
                    Agregar cliente
                </x-slot>
                <x-slot name="description">
                    Ingrese los siguientes datos para crear un nuevo cliente
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
                        <x-input-label>
                            Nombre
                        </x-input-label>
                        <x-text-input v-model="createForm.name" type="text" class="w-full mt-1"/>
                    </div>
                    <div class="col-span-6 sm:col-span-5">
                        <x-input-label>
                            URL redirección
                        </x-input-label>
                        <x-text-input v-model="createForm.redirect" type="text" class="w-full mt-1"/>
                    </div>
                </div>
                <x-slot name="actions">
                    <x-primary-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        Crear
                    </x-primary-button>
                </x-slot>
            </x-form-section>
            {{-- Listado de clientes --}}
            <x-form-section v-if="clients.length > 0">
                <x-slot name="title">
                    Listado de clientes
                </x-slot>
                <x-slot name="description">
                    Estos son los clientes que has agregado
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
                            <tr v-for="client in clients">
                                <td class="py-2">
                                    @{{client.name}}
                                </td>
                                <td class="py-2 flex divide-x divide-gray-700">
                                    <a v-on:click="show(client)"
                                    class="pr-2 hover:text-green-600 font-semibold cursor-pointer">
                                        Ver
                                    </a>
                                    <a v-on:click="edit(client)"
                                    class="px-2 hover:text-blue-600 font-semibold cursor-pointer">
                                        Editar
                                    </a>
                                    <a v-on:click="destroy(client)" 
                                    class="pl-2 hover:text-red-600 font-semibold cursor-pointer">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-form-section>
        </x-container>
        {{-- MODAL EDITAR --}}
        <x-dialog-modal modal="editForm.open">
            <x-slot name="title">
                Editar cliente
            </x-slot>
            <x-slot name="content">
                <div class="space-y-6">
                    <div v-if="editForm.errors.length > 0" class="bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded">
                        <strong class="font-bold">Error. </strong>
                        <span>Hubo un error al guardar los datos</span>
                        <ul>
                            <li v-for="error in editForm.errors">@{{error}}</li>
                        </ul>
                    </div>
                    <div class="">
                        <x-input-label-white>
                            Nombre
                        </x-input-label-white>
                        <x-text-input-white v-model="editForm.name" type="text" class="w-full mt-1"/>
                    </div>
                    <div class="">
                        <x-input-label-white>
                            URL redirección
                        </x-input-label-white>
                        <x-text-input-white v-model="editForm.redirect" type="text" class="w-full mt-1"/>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button v-bind:disabled="editForm.disabled" v-on:click="update(editForm)" type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto disabled:opacity-50">Actualizar</button>
                <button v-on:click="editForm.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
            </x-slot>
        </x-dialog-modal>
        {{-- MODAL VER --}}
        <x-dialog-modal modal="showClient.open">
            <x-slot name="title">
                Información del cliente
            </x-slot>
            <x-slot name="content">
                <div class="space-y-2">
                    <p>
                        <span class="font-semibold">CLIENTE: </span>
                        <span v-text="showClient.name"></span>
                    </p>
                    <p>
                        <span class="font-semibold">CLIENT_ID: </span>
                        <span v-text="showClient.id"></span>
                    </p>
                    <p>
                        <span class="font-semibold">CLIENT_SECRET: </span>
                        <span v-text="showClient.secret"></span>
                    </p>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button v-on:click="showClient.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cerrar</button>
            </x-slot>
        </x-dialog-modal>

    </div>


    @push('js')
        <script>
            const { createApp } = Vue;
            createApp({
                data() {
                    return{
                        clients:[],
                        createForm:{
                            name: null,
                            redirect: null,
                            errors:[],
                            disabled: false,
                        },
                        showClient:{
                            open: false,
                            id: null,
                            name: null,
                            secret: null
                        },
                        editForm:{
                            open: false,
                            id: null,
                            name: null,
                            redirect: null,
                            errors:[],
                            disabled: false,
                        },
                    }
                },
                mounted(){
                    this.getClients();
                },
                methods:{
                    getClients(){
                        axios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
                        })
                    },
                    show(client){
                        this.showClient.open = true;
                        this.showClient.id = client.id;
                        this.showClient.name = client.name;
                        this.showClient.secret = client.secret;
                    },
                    store(){
                        this.createForm.disabled = true;
                        axios.post('/oauth/clients',this.createForm)
                        .then(response => {
                            this.createForm.name = null;
                            this.createForm.redirect = null;
                            this.createForm.disabled = false;
                            this.createForm.errors = [];
                            this.show(response.data);
                            this.getClients();
                        })
                        .catch(error =>{
                            this.createForm.errors = Object.values(error.response.data.errors).flat();
                            this.createForm.disabled = false;
                        });
                    },
                    edit(client){
                        this.editForm.open = true;
                        this.editForm.id = client.id;
                        this.editForm.name = client.name;
                        this.editForm.redirect = client.redirect;
                        this.editForm.errors = [];

                    },
                    update(){
                        this.editForm.disabled = true;
                        axios.put('/oauth/clients/' + this.editForm.id,this.editForm)
                        .then(response => {
                            this.editForm.name = null;
                            this.editForm.redirect = null;
                            this.editForm.disabled = false;
                            this.editForm.errors = [];
                            this.editForm.open = false;
                            Swal.fire(
                                'Actualizado!',
                                'Los datos fueron actualizados',
                                'success'
                            );
                            this.getClients();
                        })
                        .catch(error =>{
                            this.editForm.errors = Object.values(error.response.data.errors).flat();
                            this.editForm.disabled = false;
                        });
                    },
                    destroy(client){
                        Swal.fire({
                            title: '¿Esta seguro?',
                            text: "Esto no se podrá revertir",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.delete('/oauth/clients/'+client.id)
                                .then(response => {
                                    Swal.fire(
                                        'Eliminado!',
                                        'El registro se eliminó correctamente.',
                                        'success'
                                    );
                                    this.getClients();
                                })
                            }
                        });
                    },
                }
            }).mount('#app');
        </script>
    @endpush

</x-app-layout>
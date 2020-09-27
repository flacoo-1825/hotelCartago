<template>
    <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chevron-right fa5x"></i> Reception
                        <!-- <button type="button" class="btn btn-success"  @click="openModal('product','create')">
                            <i class="fas fa-plus-circle"></i>&nbsp;Nuevo producto
                        </button> -->
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="valor">
                                      <option value="state">Nombre</option>
                                    </select>
                                    <input type="text" v-model="search" @keyup="listRoomsActive(1,search,valor)"  class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid mb-5">
                          <div class="row row_rooms">
                            <a href="#"  v-for="room in arrayRoom" :key="room.id">
                              <template v-if="room.state=='Disponible'">
                                <div class="col-ms-4 m-1" @click="openModal('room','create',room)">
                                  <div class="card-body p-3 d-flex align-items-center " :class='room.state'>
                                    <i class="fas fa-bed  p-3  mr-3"></i>
                                    <div class="text-center">
                                      <h3 v-text="room.state"></h3>
                                      <h2 v-text="room.number"></h2>
                                      <div class="text-value-sm text-primary" v-text="room.name"></div>
                                    </div>
                                  </div>
                                </div>
                              </template>
                              <template v-else>
                                <div class="col-ms-4 m-1" @click="openModal('room','edit',room)">
                                  <div class="card-body p-3 d-flex align-items-center " :class='room.state'>
                                    <i class="fas fa-bed  p-3  mr-3"></i>
                                    <div class="text-center">
                                      <h3 v-text="room.state"></h3>
                                      <h2 v-text="room.numbers"></h2>
                                      <div class="text-value-sm text-primary" v-text="room.name"></div>
                                    </div>
                                  </div>
                                </div>
                              </template>
                            </a>
                          </div>
                        </div>
                        <!-- <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>imagen</th>
                                    <th>Stock</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="product in arrayProduct" :Key="product.id">
                                   <td  v-text="product.room.state"></td>
                                   <td class="img_products">
                                     <img :src="ruta+product.img_product" alt="image_proucto">
                                   </td>
                                   <td  v-text="product.stock_product"></td>
                                   <td>
                                        <a href="#" class="btn  btn-outline-info btn-sm p-1" title="Ver" @click="openModal('product','ver',product)" ><i class="far fa-eye"></i></a>
                                        <span>&nbsp</span> 
                                        <a href="#" class="btn btn-outline-warning btn-sm p-1"  title="Editar" @click="openModal('product','editar',product)" ><i class="fas fa-user-edit"></i></a>
                                        <span>&nbsp</span>
                                        <template v-if="product.condition_product">
                                                <button class="btn btn-outline-success btn-sm p-1" title="Activo"   @click="desactivarProduct(product.id)"><i class="fas fa-check p-1"></i></button>
                                        </template>
                                        <template v-else>
                                                <a href="#" class="btn btn-outline-danger btn-sm" title="Inactivo"  @click="activarProduct(product.id)"><i class="fas fa-times"></i></a>
                                        </template>
                                   </td>
                                </tr>
                            </tbody>
                        </table> -->
                        <nav>
                            <ul class="pagination">
                              <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,search,valor)">Anterior</a>
                              </li>
                              <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,search,valor)" v-text="page"></a>
                              </li>
                              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,search,valor)">Siguiente</a>
                              </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                <div class="modal fade" :class="{'mostrar' : modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="titleModal"></h4>
                                <button type="button" class="close" @click="closeModal()">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal product">
                                    
                                    
                                    <div class="row">
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Stock</label>
                                            <input type="text" class="form-control" placeholder="" v-bind:disabled="desactivar==1">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <a  class="btn btn-danger  text-white" @click="closeModal()">Cerrar</a>
                                <a  class="btn btn-success  text-white"  @click="registerProduct()" v-if="accion==1">Registrar</a>
                                <a  class="btn btn-success  text-white" @click="updateProduct()" v-if="accion==2">Actualizar</a>
                                <hr>
                                <template v-if="arrayError">
                                    <div >
                                        <ul class="list-unstyled  alert-danger  row">
                                                <li v-text="error[0]" class="col-sm-12 col-md-6 col-lg-6 pull-left"    v-for="error in arrayError "></li>
                                        </ul>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

    </div>
            <!--closed here Data-->

           
</template>



<script>

  export default {

    data() {
        return {
            name_room : 'Clase de habitación',
            type_id:0,
            type_room : 0,
            number : '',
            price : '',
            frozen : '',
            state : '',
            price_air : '',
            arrayroom : [],
            arrayRoom : [],
            RActive : [],
            rooms : '',
            opcion : 'Elige una opción',
            modal : 0,
            titleModal : '',
            accion : 0,
            rooms_id : 0,
            desactivar : 0,
            condition : 1,
            search:'',
            valor : 'state',
            arrayError : [],
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3
          }
    },
    computed:{
        //muestra la pagina activa
        isActived: function(){
            return this.pagination.current_page;
        },
        //Calcula las paginas
        pagesNumber: function() {
            if(!this.pagination.to) {
                return [];
            }
            
            var from = this.pagination.current_page - this.offset; 
            if(from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }  

            var pagesArray = [];
            while(from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;             

        }
    },


    methods : {

        listRoomsActive(page,search,valor){
          let me=this;
          var url = 'room/active?page=' + page + '&search='+ search + "&valor=" + valor;
          axios.get(url).then(function (response) {
               var respuesta= response.data;
               me.arrayRoom = respuesta.room.data;
               me.pagination= respuesta.pagination;
              // console.log(respuesta);

          })
            .catch(function (error) {
              console.log(error);
            });
      },

        cambiarPagina(page,search,valor){
          let me = this;
          //Actualiza la página actual
          me.pagination.current_page = page;
          //Envia la petición para visualizar la data de esa página
          me.listRooms(page,search,valor);
      },

        openModal(model, accion, data = [] ){

          switch(model){
              case  "room" : {

                  switch(accion){
                      case "create" : {
                          this.modal = 1;
                          this.desactivar = 0;
                          this.titleModal = 'Ingreso de husped';
                          this.accion = 1;
                          this.type_room = 0;
                          this.number = '';
                          this.price = '';
                          this.price_air = '';
                          this.frozen = 'Seleccione una opción...';
                          this.state = 'Seleccione una opción...';
                          this.type_id=1;


                        break;       
                      };

                      case "edit" :{

                          //console.log(data);
                          this.modal = 1;
                          this.desactivar = 0;
                          this.titleModal = 'Información';
                          this.accion = 2;
                          this.habitacion_id = data['rooms_id'];
                          this.type_room =  data['type_room_id'];
                          this.number =  data['number'];
                          this.price =  data['price'];
                          this.price_air =  data['price_air'];
                          this.frozen =  data['frozen'];
                          this.state =  data['state'];
                          this.type_id= data['type_room_id'];


                          break;

                      };

                      case "ver" :{

                          //console.log(data);
                          this.modal = 1;
                          this.desactivar = 1;
                          this.titleModal = 'Información completa de la habitación';
                          this.accion = 3;
                          this.habitacion_id = data['rooms_id'];
                          this.type_room =  data['type_room'];
                          this.number =  data['number'];
                          this.price =  data['price'];
                          this.price_air =  data['price_air'];
                          this.frozen =  data['frozen'];
                          this.state =  data['state'];
                          this.type_id= data['type_room_id']



                          break;

                      }
                  }
              }
          }

      },

        closeModal(){
          this.modal = 0;
          this.arrayError = [];
          this.listRooms(1,this.search,this.valor);
        },

        registerRoom(page,search,valor){

                let me = this;
                var url  = 'room/register?page=' + page + '&search='+ search + "&valor=" + valor;
                axios.post(url,{

                            'type_room_id' :    this.type_room,
                            'number' :   this.number,
                            'price'    : this.price,
                            'price_air'    : this.price_air,
                            'frozen'    : this.frozen,
                            'state'    : this.state,
                           

                }).then(function (response) {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Tu habitación fue Registrada con Éxito',
                      showConfirmButton: false,
                      timer: 1500
                    });
                      me.closeModal();
                  })
                  .catch(function (error) {
                        var respuesta = error.response.data;
                        me.arrayError = respuesta.errors;
                        console.log(error.response.data);
                  });

            },

        updateRoom(page,search,valor){

                let me = this;
                var url = 'room/update?page=' + page + '&search='+ search + "&valor=" + valor;
                axios.put(url,{

                            'id' : this.habitacion_id,
                            'type_id' :    this.type_id,
                            'number' :   this.number,
                            'price'    : this.price,
                            'price_air'    : this.price_air,
                            'frozen'    : this.frozen,
                            'state'    : this.state,


                }).then(function (response) {
                      Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Habitación Actualizada con Éxito',
                      showConfirmButton: false,
                      timer: 1500
                    });
                      me.closeModal();
                  })
                  .catch(function (error) {
                       var respuesta = error.response.data;
                       me.arrayError = respuesta.errors;
                       console.log(error.response.data);
                  });

            },

        activarRoom(id){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: 'Está seguro?',
                  text: "Va a Activar ésta habitación!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Si, Activala',
                  cancelButtonText: 'No, Cancelar!',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) { 

                      let me = this;

                          axios.put('room/activo',{
                              'id': id
                          }).then(function (response) {
                              me.listRoom(1,'','valor');
                           
                          }).catch(function (error) {
                              console.log(error);
                          });
                      

                    swalWithBootstrapButtons.fire(
                      'Activado!',
                      'Tu habitación quedó Activada.',
                      'success'
                    )
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelado',
                      'Tu tipo de habitación sigue Desactivado :)',
                      'error'
                    )
                  }
                })
            },

        desactivarRoom(id){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: 'Está seguro?',
                  text: "Va a desactivar ésta habitación!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Si, Desactivala',
                  cancelButtonText: 'No, Cancelar!',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) { 

                      let me = this;

                          axios.put('room/inactivo',{
                              'id': id
                          }).then(function (response) {
                              me.listRooms(1,'','valor');
                           
                          }).catch(function (error) {
                              console.log(error);
                          });
                      

                    swalWithBootstrapButtons.fire(
                      'Desativado!',
                      'Tu habitación quedó desativada.',
                      'success'
                    )
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelado',
                      'Tu habitación está a salvo :)',
                      'error'
                    )
                  }
                })
              }

            },

      mounted() {
        this.listRoomsActive(1,this.search,this.valor);
      }
  }
</script>

<style>
     
    .modal-content{
    width:100% ! important;
    position:  absolute ! important; 
    }
    .mostrar{
    display:  list-item ! important;  
    opacity:  1 ! important;
    position:  absolute ! important;
    background-color: #3c29297a !important;
    }

    .Disponible{
      border: 1px solid rgb(33, 136, 56);
      /* border: 1px solid #e0e5ec;  */
      border-radius: 5%;
      color:rgb(33, 136, 56) ;
      box-shadow: 8px 8px 16px rgba(165,177,198, 0.8),
	    -8px -8px 16px rgba(255,255,255,0.8);
      -webkit-transition: all .3s ease;
      -moz-transition: all .3s ease;
      -ms-transition: all .3s ease;
      -o-transition: all .3s ease;
      transition: all .3s ease;
    }

    .Disponible i{
      font-size: 45px;
      color:rgb(33, 136, 56) ;
    }

    .Disponible:hover{
      background-color: rgba(15, 225, 61, 0.4) ;
      color: #000;
      transform: scaleY(1.1);
    }

    .Disponible:hover i{
      color:#000 ;
    }
    .row_rooms a{
      text-decoration: none;
    }

    .Ocupada{
      border: 1px solid rgba(177, 32, 32, 0.859) ;
      /* border: 1px solid #e0e5ec;  */
      border-radius: 5%;
      color:rgba(177, 32, 32, 0.859) ;
      box-shadow: 8px 8px 16px rgba(165,177,198, 0.8),
	    -8px -8px 16px rgba(255,255,255,0.8);
      -webkit-transition: all .3s ease;
      -moz-transition: all .3s ease;
      -ms-transition: all .3s ease;
      -o-transition: all .3s ease;
      transition: all .3s ease;
    }

    .Ocupada i{
      font-size: 45px;
      color:rgba(177, 32, 32, 0.859);
    }

     .Ocupada:hover{
      background-color:rgba(177, 32, 32, 0.571) ;
      color: #000;
      transform: scaleY(1.1);
    }

    .Ocupada:hover i{
      color:#000 ;
    }

</style>
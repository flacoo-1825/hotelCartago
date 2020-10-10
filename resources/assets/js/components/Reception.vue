<template>
    <div class="container-fluid">

        <template v-if="factura==0">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chevron-right fa5x"></i> Reception
                        <button type="button" class="btn btn-success"  @click="openModal('product','create')">
                            <i class="fas fa-cash-register"></i> Venta Extra
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="valor">
                                      <option value="state">Estado</option>
                                      <option value="name_type_room">Habitación</option>
                                    </select>
                                    <input type="text" v-model="search" @keyup="listRoomsActive(1,search,valor)"  class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid mb-5">
                          <div class="row row_rooms">
                            <a href="#" class="col-sm-4 col-md-4"  v-for="room in arrayRoom" :key="room.id">
                              <template v-if="room.state=='Disponible'">
                                <div class=" m-1 disponible" @click="openModal('room','create',room)">
                                  <div class="card-body p-3 d-flex align-items-center " :class='room.state'>
                                    <i class="fas fa-bed  p-3  mr-3"></i>
                                    <div class="text-center">
                                      <h3 v-text="room.state"></h3>
                                      <h2 v-text="room.number"></h2>
                                      <h5 class="text-value-sm text-black" v-text="room.name_type_room"></h5>
                                    </div>
                                  </div>
                                </div>
                              </template>
                              <template v-else>
                                <div @click="openModal('room','edit',room)">
                                <!-- <div @click="factura=1,room"> -->
                                  <div class=" m-1 card-body p-3 d-flex align-items-center " :class='room.state'>
                                    <i class="fas fa-bed  p-3  mr-3"></i>
                                    <div class="text-center">
                                      <h3 v-text="room.state"></h3>
                                      <h2 v-text="room.number"></h2>
                                      <h5 class="text-value-sm text-black" v-text="room.name_type_room"></h5>
                                    </div>
                                  </div>
                                </div>
                              </template>
                            </a>
                          </div>
                        </div>
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
                <!--open modal acomp -->
                <div class="modal fade" tabindex="-1" :class="{'mostrar' : add}" >
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content container bg-container-modal">
                      <div class="text-center">
                        <h3 class="modal-title degraded-orange" v-text="titleModal"></h3>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col">
                            <table class="table table-hover  table-sm" >
                              <thead >
                                <tr class="bg-material-orange">
                                  <th>Nombre</th>
                                  <th>Primer Apellido</th>
                                  <th>segundo Apellido</th>
                                  <th>Cédula</th>
                                  <th>Fecha de Nacimiento</th>
                                  <th>Opciones</th>
                                </tr>
                              </thead>
                              <tbody class="bg-white text-center">
                                <tr v-for="acomp in listAcomp " :key="acomp.id">
                                  <td v-text="acomp.name_acomp" ></td>
                                  <td v-text="acomp.firstSurname_acomp" ></td>
                                  <td v-text="acomp.secondSurname_acomp" ></td>
                                  <td v-text="acomp.cedula_acomp" ></td>
                                  <td v-text="acomp.birth_date_acomp" ></td>
                                  <!-- <td v-text:format="dateformat(acomp.birth_date_acomp)"></td> -->
                                  <td>
                                    <a href="#" class="btn btn-danger "  title="Eliminar" @click="deleteAcomp(acomp)" >
                                      <i class="fas fa-trash-alt"></i> Eliminar
                                    </a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                                  
                              </div>
                          </div>
                      
                      </div>
                      <div class="row modal-footer">
                        <div class="col-lg-2">
                          <a class="btn btn-danger  text-white" @click="closeModalAcomp()">Cerrar</a>
                        </div>       
                      </div>
                      <!-- /.modal-content -->
                    </div>
                  <!-- /.modal-dialog -->
                  </div>
                </div>
                <!-- closed modal acomp -->
                <!-- Fin ejemplo de tabla Listado -->
                <div class="modal fade" :class="{'mostrar' : modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="titleModal"></h4>
                                <button type="button" class="close" @click="closeModal()">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal product customers">
                                  <template v-if="stateRoom=='Disponible'">
                                    <div class="row">
                                        <div class="col-md-3 mb-2"></div>
                                        <div class="col-md-6 mb-2">
                                            <label for="text-input ">Ingrese la cédula del huésped</label>
                                            <input type="text"  class="form-control" placeholder="" v-bind:disabled="desactivar==1" v-model="cc_client">
                                        </div>
                                    </div>
                                  </template>
                                  <template v-else-if="stateRoom=='Ocupada'">
                                    <div class="row">
                                      <div class="col-md-6 mb-2 certificate">
                                      </div>
                                      <div class="col-md-6 mb-2 certificate  input-group">
                                          <label for="text-input ">Factura</label>
                                          <h2 v-text="number_check"></h2>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 mb-2">
                                            <label for="text-input ">Cliente : <span v-text="name_client+' '+firstSurname_client + ' ' +secondSurname_client"></span></label>
                                        </div>
                                        <div class="col-lg-3 mb-2">
                                            <label for="text-input ">Documento <span v-text="cedula_client"></span></label>
                                        </div>
                                        <div class="col-lg-3 mb-2">
                                            <label for="text-input ">Celular <span v-text="phone_client"></span></label>
                                        </div>
                                    </div>
                                  </template>
                                  <template v-else-if="stateRoom=='certificate'">
                                    <div class="row">
                                      <div class="col-md-6 mb-2 certificate">
                                      </div>
                                      <div class="col-md-6 mb-2 certificate  input-group">
                                          <label for="text-input ">Acta</label>
                                          <h2 v-text="number_certificate"></h2>
                                      </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-2 text-center certificate">
                                            <h3>Información del huéped</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label for="text-input ">Cliente</label>
                                            <input type="text" class="form-control" placeholder=""  v-model="name_client">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Primer apellido</label>
                                            <input type="text" class="form-control" v-model="firstSurname_client"    placeholder="introduzca apellido paterno">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Segundo apellido</label>
                                            <input type="text" class="form-control" v-model='secondSurname_client'   placeholder="introduzca apellido materno">
                                         </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Cédula</label>
                                            <input type="text" class="form-control"  v-model="cedula_client"  v-bind:disabled="desactivar==1" >
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Celular</label>
                                            <input type="text" class="form-control"  v-model=' phone_client '  placeholder="introduzca el celular">
                                        </div>        
                                        <div class="col-sm-12 col-md-4">  
                                            <label for="email-input ">Nacionalidad</label>
                                            <input type="text" class="form-control"  v-model=' nationality_client '  placeholder="introduzca la nacionalidad">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="email-input ">Correo Electrónico</label>
                                            <input type="email" class="form-control"  v-model=' email_client '  placeholder="introduzca el correo">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Ciudad de origen</label>
                                            <input type="text" class="form-control"  v-model="cityOrigin_certificate"  placeholder="introduzca la ciudad">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Ciudad de destino</label>
                                            <input type="text" class="form-control" v-model="cityDestination_certificate"   placeholder="introduzca la ciudad">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 input-group">
                                          <div class="input-group">
                                            <label for="text-input ">Temperatura de entrada</label>
                                          </div>
                                          <input type="number" class="form-control"  v-model="temperature_entry_client"  placeholder="">
                                          <div class="input-group-append">
                                            <span class="input-group-text">°C</span>
                                          </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 input-group">
                                          <div class="input-group">
                                            <label for="text-input ">Temperatura de salida</label>
                                          </div>
                                          <input type="number" class="form-control"  v-model="temperature_exit_client" v-bind:disabled="desactivar==1" placeholder="">
                                          <div class="input-group-append">
                                            <span class="input-group-text">°C</span>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-2 mt-4 certificate text-center ">
                                            <h3>Información del vehículo</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Placa Auto</label>
                                            <input type="text" class="form-control"  v-model="placaCar_certificate"  placeholder="Ej: MNZ 328">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Placa Moto</label>
                                            <input type="text" class="form-control"  v-model="placabike_certificate"  placeholder="Ej: MNZ 328">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-2 mt-4 certificate text-center ">
                                            <h3>Información de los acompañantes</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="text-input ">Cantidad de Personas</label>
                                            <div class="row">
                                              <div class="col">
                                                <label for="text-input ">Adultos</label>
                                                <input type="number" class="form-control" v-model="adults_certificate"  placeholder="Ej: 1">
                                              </div>
                                              <div class="col">
                                                <label for="text-input ">Niños</label>
                                                <input type="number" class="form-control" v-model="children_certificate"  placeholder="Ej: 0">
                                               </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label for="text-input ">Fecha de ingreso</label>
                                            <date-picker v-model="entry_certificate"   :language="es" :lang="lang" valueType="format"></date-picker>
                                        </div>
                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label for="text-input ">Observaciones</label>
                                            <textarea  class="form-control"   v-model="observation_certificate" rows="2"></textarea> 
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-lg-4 mb-2">
                                        <label for="text-input ">Nombre</label>
                                        <input type="text" v-model="name_acomp" class="form-control"  placeholder="introduzca el nombre sin apellidos">
                                      </div>

                                      <div class="col-lg-4 mb-2">
                                        <label for="text-input ">Primer apellido</label>
                                        <input type="text" v-model="firstSurname_acomp" class="form-control" placeholder="introduzca apellido paterno">
                                      </div>

                                      <div class="col-lg-4 mb-2">
                                        <label for="text-input ">Segundo apellido</label>
                                        <input type="text" v-model="secondSurname_acomp" class="form-control" placeholder="introduzca apellido materno">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-lg-4 mb-2">
                                        <label for="text-input ">Cédula</label>
                                        <input type="text" v-model="cedula_acomp" class="form-control" placeholder="introduzca número de cédula">
                                      </div>

                                      <div class="col-lg-4 mb-2">
                                        <label for="text-input ">Fecha de Nacimiento</label>
                                        <date-picker v-model="birth_date_acomp"   :language="es" :lang="lang" valueType="format"></date-picker>
                                      </div>
                                    </div>
                                    <div class="row">   
                                      <div class="col-md-10">
                                        <a @click="openModal('room','agregar')" href="#" class="btn  btn-info">
                                          <i class="fas fa-list"></i> Ver Lista
                                        </a>
                                      </div>
                                      <div class="col-md-2">
                                        <a @click="addAcomp()" href="#" class="btn  btn-success" title="agregar" >
                                           <i class="fas fa-plus-circle"></i> agregar
                                        </a>
                                      </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 mb-2 mt-4 certificate text-center ">
                                            <h3>Información de la habitación</h3>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="email-input ">Tipo de ventilación</label>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" :value="price" checked>
                                              <label class="form-check-label" for="exampleRadios1">
                                                Ventilador
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" :value="price_air">
                                              <label class="form-check-label" for="exampleRadios2">
                                                Aire Acondicionado
                                              </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Ciudad de origen</label>
                                            <input type="text" class="form-control"  v-model="cityOrigin_certificate"  placeholder="introduzca la ciudad">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="text-input ">Ciudad de destino</label>
                                            <input type="text" class="form-control" v-model="cityDestination_certificate"   placeholder="introduzca la ciudad">
                                        </div>
                                    </div>
                                  </template>
                                  <template v-else-if="stateRoom=='register'">
                                    <div class="row">
                                      <div class="col-lg-4 mb-2">
                                          <label for="text-input ">Nombre</label>
                                          <input type="text" class="form-control" placeholder="" v-model="name_client">
                                      </div>
                                      <div class="col-lg-4 mb-2">
                                          <label for="text-input ">Primer Apellido</label>
                                          <input type="text" class="form-control" placeholder="" v-model="firstSurname_client">
                                      </div>
                                      <div class="col-lg-4 mb-2">
                                          <label for="text-input ">Segundo Apellido</label>
                                          <input type="text" class="form-control" placeholder="" v-model="secondSurname_client">
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Identificación</label>
                                            <input type="text" class="form-control" placeholder="" v-model="cedula_client">
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Edad</label>
                                            <input type="text" class="form-control" placeholder="" v-model="age_client">
                                        </div>
                                        
                                        <div class="col-lg-4 mb-2">
                                        <label for="text-input ">Fecha de Nacimiento</label>
                                        <date-picker v-model="birth_date_client"   :language="es" :lang="lang" valueType="format"></date-picker>
                                        <!-- <Datepicker  v-model='birth_date_client'    :language="es" :value="Date" :format="dateformat(birth_date_client)"  ></Datepicker> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Teléfono</label>
                                            <input type="text" class="form-control" placeholder="" v-model="phone_client">
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Género</label>
                                            <select class="form-control custom-select " v-model=' gender_client ' >
                                                    <option value="0">Seleccione una opción</option>
                                                    <option>Femenino</option>
                                                    <option>Masculino</option>
                                                    <option>No especifica</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Estado</label>
                                            <select class="form-control custom-select" v-model='state_client ' >
                                                    <option value="0">Seleccione una opción</option>
                                                    <option>Soltero(a)</option>
                                                    <option>Casado(a)</option>
                                                    <option>Union Libre</option>
                                                    <option>Viudo(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Dirección</label>
                                            <input type="text" class="form-control" placeholder="" v-model="address_client">
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Ciudad</label>
                                            <input type="text" class="form-control" placeholder="" v-model="city_client">
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Nacionalidad</label>
                                            <input type="text" class="form-control" placeholder="" v-model="nationality_client">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-2">
                                            <label for="text-input ">Correo electrónico</label>
                                            <input type="email" class="form-control"  v-model=' email_client '  placeholder="">
                                        </div>
                                    </div>
                                  </template>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <a  class="btn btn-danger  text-white" @click="closeModal()">Cerrar</a>
                                <a  class="btn btn-success  text-white"  @click="search_client(cc_client)" v-if="accion==1">Ingresar</a>
                                <a  class="btn btn-success  text-white" @click="registerCustomers()" v-if="accion==3">Registrar</a>
                                <a  class="btn btn-success  text-white" @click="stateBusy()" v-if="accion==4">Hospedar</a>
                                <hr>
                                <!-- <template v-if="arrayError">
                                    <div >
                                        <ul class="list-unstyled  alert-danger  row">
                                                <li v-text="error[0]" class="col-sm-12 col-md-6 col-lg-6 pull-left"    v-for="error in arrayError "></li>
                                        </ul>
                                    </div>
                                </template> -->
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
        </template>
                
        <template v-if="factura==1">
          <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chevron-right fa5x"></i> Factura
                        <span>
                            <button type="button" class="btn btn-danger"  @click="factura=0">
                              <i class="fas fa-times-circle"></i> Cerrar
                            </button>
                            <a  class="btn btn-info shadow text-white" @click="stateFree()" v-if="accion==2"><i class="fas fa-money-check-alt"></i> Facturar</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-5">
                          <div class="row">
                            <div class="col-md-8 mb-2">
                            </div>
                            <div class="col-md-4 mb-2 certificate  input-group">
                                <label for="text-input ">Factura</label>
                                <h2 v-text="number_check"></h2>
                            </div>
                          </div>
                          <div class="row mb-4">
                              <div class="col-md-12 mb-2 text-center certificate">
                                  <h3>Información del huéped</h3>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2 input-group">
                                <label for="text-input ">Cliente : 
                                  <span v-text="name_client">
                                    </span>&nbsp
                                    <span v-text="firstSurname_client">&nbsp
                                    </span>
                                    <span v-text="secondSurname_client">&nbsp
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-6 mb-2 input-group">
                                <label for="text-input ">Celular : <span v-text="phone_client"></span></label>
                            </div>
                          </div>
                          <div class="row mb-4">
                              <div class="col-md-12 mb-2 text-center certificate">
                                  <h3>Detalle habitación</h3>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 mb-2 input-group">
                                <label for="text-input ">tipo ventilación : <span v-text="frozen"></span></label>
                            </div>
                            <div class="col-md-4 mb-2 input-group">
                                <label for="text-input ">Precio : <span >{{price | currency}}</span></label>
                            </div>
                          </div>
                          <div class="row mb-4">
                              <div class="col-md-12 mb-2 text-center certificate">
                                  <h3>Ventas adiccionales</h3>
                              </div>
                              <div class="col-md-12 mb-2 text-right certificate">
                                  <button type="button" class="btn btn-success"  @click="openModal('room','sale')">
                                    <i class="fas fa-cash-register"></i> Venta Extra
                                  </button>
                              </div>
                          </div>
                          <div class="row">
                            <table class="table table-bordered table-striped table-sm">
                              <thead>
                                  <tr>
                                      <th>Detalle de la venta</th>
                                      <th>Estado</th>
                                      <th>total</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr class="text-center" v-for="room in arrayRoom" :Key="room.id">
                                    <td><a href="#" class="btn  btn-info btn-sm p-1" title="Ver" @click="openModal('room','ver',room)" ><i class="far fa-eye"></i> Ver detalle</a></td>
                                    <td  v-text="room.price"></td>
                                    <td class="d-flex justify-content-between">
                                        <template v-if="room.condition">
                                            <button class="btn btn-success btn-sm p-1" title="Activo"   @click="desactivarRoom(room.id)"><i class="fas fa-check p-1"></i> Activar</button>
                                        </template>
                                        <template v-else>
                                            <a href="#" class="btn btn-danger btn-sm" title="Inactivo"  @click="activarRoom(room.id)"><i class="fas fa-times"></i> Desactivar</a>
                                        </template>
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
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
                    </div>
          </div>
        </template>
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : add}" >
                  <div class="modal-dialog modal-dialog-scroll modal-lg" role="document">
                    <div class="modal-content container bg-container-modal">
                      <div class="text-center">
                        <h3 class="modal-title degraded-orange" v-text="titleModal"></h3>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                              <div class="input-group">
                                  <input type="text" v-model="search" @keyup="listProductActive(1,search,valor)"  class="form-control" placeholder="Producto a buscar">
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                              </div>
                            </div>
                          <div class="col">
                            <table class="table table-hover  table-sm text-center" >
                              <thead >
                                <tr>
                                  <th>Producto</th>
                                  <th>Precio C/u</th>
                                  <th>cantidad</th>
                                  <th>total</th>
                                  <th >Opciones</th>
                                </tr>
                              </thead>
                              <tbody class="bg-white text-center table-bordered">
                                <tr v-for="product in arrayProducts " :key="product.id">
                                  <td><a href="#" class="btn btn-primary" v-text="product.name_product" ></a></td>
                                  <td  >Precio : {{product.sale_product | currency}} </td>
                                  <td>
                                    <input type="number" v-model="cantidad_product">
                                  </td>
                                  <td v-text="product.sale_product*cantidad_product"></td>
                                  <!-- <td v-text:format="dateformat(acomp.birth_date_acomp)"></td> -->
                                  <td>
                                    <a href="#" class="btn btn-success "  title="Agregar" @click="addProduct(product)" >
                                      <i class="fas fa-trash-alt"></i> Agregar
                                    </a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                                  
                              </div>
                          </div>
                      
                      </div>
                      <div class="row modal-footer">
                        <div class="col-lg-2">
                          <a class="btn btn-danger  text-white" @click="closeModalAcomp()">Cerrar</a>
                        </div>       
                      </div>
                      <!-- /.modal-content -->
                    </div>
                  <!-- /.modal-dialog -->
                  </div>
        </div>
        <template v-if="factura==2">
          <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chevron-right fa5x"></i> venta
                        <span>
                            <button type="button" class="btn btn-danger"  @click="factura=0">
                              <i class="fas fa-times-circle"></i> Cerrar
                            </button>
                            <a  class="btn btn-info shadow text-white" @click="stateFree()" v-if="accion==2"><i class="fas fa-money-check-alt"></i> Facturar</a>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid mb-5">
                          <div class="row">
                            <div class="col-md-8 mb-2">
                            </div>
                            <div class="col-md-4 mb-2 certificate  input-group">
                                <label for="text-input ">Factura</label>
                                <h2 v-text="number_check"></h2>
                            </div>
                          </div>
                          <div class="row mb-4">
                              <div class="col-md-12 mb-2 text-center certificate">
                                  <h3>Productos para ser facturados</h3>
                              </div>
                              <div class="col-md-12 mb-2 text-right certificate">
                                  <button type="button" class="btn btn-success"  @click="openModal('room','products')">
                                    <i class="fas fa-plus-circle"></i> Venta Extra
                                  </button>
                              </div>
                          </div>
                          <div class="row">
                            <table class="table table-bordered table-striped table-sm">
                              <thead>
                                  <tr>
                                      <th>Producto</th>
                                      <th>valor C/u</th>
                                      <th>Cantidad</th>
                                      <th>subTotal</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr class="text-center" v-for="product in listProduct" :Key="product.id">
                                    <td class="imgProduct">
                                      <img :src="ruta+product.url_img" alt="not fount">
                                    </td>
                                    <td  v-text="product.sale_product"></td>
                                    <td  v-text="product.cantidad_product"></td>
                                    <td class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-danger btn-sm" title="Inactivo"  @click="deleteProduct(product)"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
          </div>
        </template>
    </div>
            <!--closed here Data-->
  
</template>



<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';
  import {es}  from 'vue2-datepicker/locale/es';
  import VueCurrencyFilter from 'vue-currency-filter'
  Vue.use(VueCurrencyFilter, {
    symbol: '$', // El símbolo, por ejemplo €
    thousandsSeparator: ',', // Separador de miles
    fractionCount: 2, // ¿Cuántos decimales mostrar?
    fractionSeparator: '.', // Separador de decimales
    symbolPosition: 'front', // Posición del símbolo. Puede ser al inicio ('front') o al final ('') es decir, si queremos que sea al final, en lugar de front ponemos una cadena vacía ''
    symbolSpacing: true // Indica si debe poner un espacio entre el símbolo y la cantidad
  })
  export default {

    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 7,
                    },
                    monthBeforeYear: false,
            },
            ruta : 'img/products/',
            url_img : '',
            total : '',
            name_product : '',
            sale_product : 0,
            cantidad_product : 0,
            factura : 0,
            number_check : '',
            name_room : 'Clase de habitación',
            type_id:0,
            type_room : 0,
            number_update_check : '',
            stateRoom : 'Disponible',
            cc_client: '',
            arrayUsuarioCliente : [],
            client_id : 0,
            temperature_exit_client : 0,
            temperature_entry_client : 0,
            cedula_client : '',
            entry_certificate : new Date(),
            cityOrigin_certificate : '',
            cityDestination_certificate : '',
            children_certificate : '',
            adults_certificate : '',
            observation_certificate : '',
            placaCar_certificate : '',
            placabike_certificate : '',
            name_client : '',
            firstSurname_client : '',
            secondSurname_client : '',
            phone_client : '',
            birth_date_client : new Date(),
            gender_client : 0,
            age_client : '',
            state_client : 0,
            number_certificate : '032CT',
            number_update : 0,
            email_client : '',
            address_client : '',
            city_client : '',
            nationality_client : '',
            number : '',
            price : '',
            frozen : '',
            state : '',
            price_air : '',
            name_acomp : '',
            firstSurname_acomp : '',
            secondSurname_acomp : '',
            cedula_acomp : '',
            birth_date_acomp : new Date(),
            listAcomp : [],
            listProduct : [],
            arrayroom : [],
            client : [],
            arrayRoom : [],
            arrayProducts : [],
            rooms : '',
            opcion : 'Elige una opción',
            modal : 0,
            titleModal : '',
            accion : 0,
            rooms_id : 0,
            add : 0,
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
            offset : 3,
            es : es,
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

        },

    },


    methods : {
      
        listProductActive(page,search){
          let me=this;
          var valor = 'name_product'
          var url = 'product/active?page=' + page + '&search='+ search + "&valor=" + valor;
          axios.get(url).then(function (response) {
               var respuesta= response.data;
               me.arrayProducts = respuesta.products.data;
               me.pagination= respuesta.pagination;
              // console.log(me.arrayProducts);

          })
            .catch(function (error) {
              console.log(error);
              });
        },

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

        search_certificate(){
          let me=this;
          var id_search = 1;
          var url = 'counter/searchCertificate';
          axios.get(url).then(function (response) {
               var respuesta= response.data;
               me.number_update = respuesta[0].number_certificate;
               var end = respuesta[0].end_certificate;
               me.number_certificate = me.number_update+end;
              //  me.arrayRoom = respuesta.room.data;
              // console.log(number+end);

          })
            .catch(function (error) {
              console.log(error);
              });
        },

        search_check(){
          let me=this;
          var id_search = 1;
          var url = 'counter/searchCheck';
          axios.get(url).then(function (response) {
               var respuesta= response.data;
               me.number_update_check = respuesta[0].number_check;
               var end = respuesta[0].end_check;
               me.number_check = me.number_update_check+end;
              //  me.arrayRoom = respuesta.room.data;
              //  console.log(me.number_check+end);

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
          me.listRoomsActive(page,search,valor);
      },

        search_client(cc_client){
                let me=this;
                var url = 'customers/searchClient?cc_client=' + cc_client;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuarioCliente = respuesta.client;
                    // console.log(me.arrayUsuarioCliente);
                    if (me.arrayUsuarioCliente.name_client === 'Usuario no registrado') {
                         me.closeModal();
                         const swalWithBootstrapButtons = Swal.mixin({
                          customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                          },
                          buttonsStyling: false
                          })
                          swalWithBootstrapButtons.fire({
                            title: 'El huésped no está registrado!',
                            text: "Desea registrar el huésped?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Registrar',
                            cancelButtonText: 'Cancelar!',
                            reverseButtons: true
                          }).then((result) => {
                                if (result.value) { 
                                  me.openModal('room','register',me.arrayUsuarioCliente);
                                  // swalWithBootstrapButtons.fire(
                                  //   'Huésped registrado!',
                                  //   'Ya puedes ingresarlo.',
                                  //   'success'
                                  // )
                                } else if (result.dismiss === Swal.DismissReason.cancel ){
                                  swalWithBootstrapButtons.fire(
                                    'Cancelado',
                                    'Recuerda él huésped no está en la base de datos :)',
                                    'error'
                                  )
                                  }
                              })
                    }else{
                        me.closeModal();
                        me.openModal('room','certificate',me.arrayUsuarioCliente);
                    }
                   
                    
                    // me.id_client = respuesta.client.id;
                })
                  .catch(function (error) {
                    console.log(error);
                  });
      },
        
        registerCustomers(page,search,valor){

                let me = this;
                var url  = 'customers/register?page=' + page + '&search='+ search + "&valor=" + valor;
                axios.post(url,{

                            'cedula_client' :    this.cedula_client,
                            'name_client' :    this.name_client,
                            'firstSurname_client' :   this.firstSurname_client,
                            'secondSurname_client'    : this.secondSurname_client,
                            'birth_date_client'    : this.birth_date_client,
                            'gender_client'    : this.gender_client,
                            'age_client'    : this.age_client,
                            'address_client'    : this.address_client,
                            'city_client'    : this.city_client,
                            'nationality_client'    : this.nationality_client,
                            'state_client'    : this.state_client,
                            'phone_client'    : this.phone_client,
                            'email_client'    : this.email_client,
                    
                           

                }).then(function (response) {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Tu huésped fue registrado con éxito',
                      showConfirmButton: false,
                      timer: 1500
                    });
                      me.closeModal();
                      me.search_client(me.cc_client);
                  })
                  .catch(function (error) {
                        var respuesta = error.response.data;
                        me.arrayError = respuesta.errors;
                        console.log(error.response.data);
                  });

            },

        registerCertificate(){

                let me = this;
                var url  = 'certificate/register';
                axios.post(url,{

                            'client_id'                   :    this.client_id,
                            'number_certificate'          :    this.number_certificate,
                            'cityOrigin_certificate'      :    this.cityOrigin_certificate,
                            'cityDestination_certificate' :    this.cityDestination_certificate,
                            'placabike_certificate'       :    this.placabike_certificate,
                            'placaCar_certificate'        :    this.placaCar_certificate,
                            'adults_certificate'          :    this.adults_certificate,
                            'children_certificate'        :    this.children_certificate,
                            'entry_certificate'           :    this.entry_certificate,
                            'observation_certificate'     :    this.observation_certificate,
                            'listAcomp'                   :    this.listAcomp,
                            'temperature_exit_client'     :    this.temperature_exit_client,
                            'temperature_entry_client'    :    this.temperature_entry_client,
            
                    
                           

                }).then(function (response) {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Tu acta fue registrada con éxito',
                      showConfirmButton: false,
                      timer: 1500
                    });
                     

                  })
                  .catch(function (error) {
                        var respuesta = error.response.data;
                        me.arrayError = respuesta.errors;
                        console.log(error.response.data);
                  });

            },


        openModal(model, accion, data = [] ){

          switch(model){
              case  "room" : {

                  switch(accion){
                      case "create" : {
                          this.modal = 1;
                          this.stateRoom = 'Disponible'
                          this.desactivar = 0;
                          this.titleModal = 'Ingreso de huésped';
                          this.accion = 1;
                          this.cc_client = '';
                          this.rooms_id = data['id'];

                        break;       
                      };

                      case "edit" :{

                          // console.log(data);
                          this.search_check();
                          this.factura = 1;
                          // this.stateRoom = 'Ocupada'
                          this.desactivar = 0;
                          this.titleModal = 'Información';
                          this.accion = 2;
                          this.rooms_id = data['id'];
                          this.type_room =  data['type_room_id'];
                          this.number =  data['number'];
                          this.price =  data['price'];
                          this.price_air =  data['price_air'];
                          this.frozen =  data['frozen'];
                          this.state =  data['state'];
                          this.type_id= data['type_room_id'];
                          this.name_client=  data['name_client'];
                          this.cedula_client=  data['cedula_client'];
                          this.phone_client=  data['phone_client'];
                          this.firstSurname_client =  data['firstSurname_client'];
                          this.secondSurname_client =  data['secondSurname_client'];
                          this.number_update_check =  this.number_update_check;
                          this.name_type_room = data['name_type_room'];



                          break;

                      };

                      case "certificate" :{
                          this.search_certificate();
                          //console.log(data);
                          this.modal = 1;
                          this.desactivar = 1;
                          this.stateRoom = 'certificate'
                          this.titleModal = 'Acta de entrada';
                          this.accion = 4;
                          this.number_certificate;
                          this.rooms_id ;
                          this.children_certificate = '';
                          this.adults_certificate = '';
                          this.cityOrigin_certificate = '';
                          this.cityDestination_certificate = '';
                          this.name_client = data['name_client'];
                          this.type_room =  data['type_room'];
                          this.number =  data['number'];
                          this.price =  data['price'];
                          this.price_air =  data['price_air'];
                          this.frozen =  data['frozen'];
                          this.state =  data['state'];
                          this.client_id = data['id'];
                          this.type_id= data['type_room_id'];
                          this.cedula_client=  data['cedula_client'];
                          this.firstSurname_client =  data['firstSurname_client'];
                          this.secondSurname_client =  data['secondSurname_client'];
                          this.birth_date_client =  data['birth_date_client'];
                          this.gender_client =  data['gender_client'];
                          this.age_client =  data['age_client'];
                          this.address_client =  data['address_client'];
                          this.city_client =  data['city_client'];
                          this.nationality_client =  data['nationality_client'];
                          this.state_client =  data['state_client'];
                          this.phone_client =  data['phone_client'];
                          this.email_client =  data['email_client'];

                          break;

                      };

                      case "register" :{
                          //console.log(data);
                          this.modal = 1;
                          this.desactivar = 1;
                          this.stateRoom = 'register'
                          this.titleModal = 'Registro de nuevo huésped';
                          this.accion = 3;
                          this.cedula_client= '';
                          this.name_client = '';
                          this.birth_date_client = '';
                          this.firstSurname_client = '';
                          this.secondSurname_client = '';
                          this.gender_client = 0;
                          this.age_client = '';
                          this.address_client = '';
                          this.city_client = '';
                          this.nationality_client = '';
                          this.state_client = 0;
                          this.phone_client = '';
                          this.email_client = '';
                         
                          break;

                      };

                      case "agregar" :{
                        this.add = 1;
                        this.modal = 0;
                        this.titleModal = 'Listado de Acompañantes';

                        break;
                      };

                       case "sale" :{

                        this.factura = 2;
                        this.titleModal = 'Productos';

                        break;
                      };

                      case "products" :{
                         
                        this.add = 1;
                        this.titleModal = 'Productos';
                        this.arrayProducts = [];
                        this.name_product = '';
                        this.cantidad_product = 1;
                        this.sale_product = 0;
                        this.search = '';

                        break;
                      };
                  }
              }
          }

      },

        closeModal(){
          this.modal = 0;
         // this.arrayError = [];
          this.listRoomsActive(1,this.search,this.valor);
        },
        closeModalAcomp(){
          this.add = 0;
          this.modal = 1;
          this.titleModal ='Acta de entrada'; 
        },
        updateCertificate(){
          let me=this;
          var url = 'counter/update';
          axios.put(url,{

                      'option' : 3,
                      'number_certificate' :    this.number_update,


          })
            .catch(function (error) {
                  var respuesta = error.response.data;
                  me.arrayError = respuesta.errors;
                  console.log(error.response.data);
            });

        },
        stateBusy(){

                let me = this;
                me.registerCertificate();
                me.updateCertificate();
                var url  = 'room/statebusy';
                axios.put(url,{

                            'id' :    this.rooms_id,
                            'client_id' : this.client_id,

                }).then(function (response) {
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Tu habitación queda en estado Ocupada!',
                      showConfirmButton: false,
                      timer: 1500
                    });
                      me.closeModal();
                      me.updateCustomers();
                      me.listRoomsActive(1,this.search,this.valor);
                  })
                  .catch(function (error) {
                        // var respuesta = error.response.data;
                        // me.arrayError = respuesta.errors;
                        // console.log(error.response.data);
                  });

            },

        stateFree(){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: 'Está seguro?',
                  text: "Va a facturar ésta habitación!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Si, facturar',
                  cancelButtonText: 'No, Cancelar!',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) { 

                        let me = this;
                        var url  = 'room/statefree';
                        axios.put(url,{

                            'id' :    this.rooms_id,
                            // 'client_id' : 1,

                          }).then(function (response) {
                              me.listRoomsActive(1,'','valor');
                              me.factura = 0;
                           
                          }).catch(function (error) {
                              console.log(error);
                          });
                      

                    swalWithBootstrapButtons.fire(
                      
                      'Activado!',
                      'Tu habitación quedó Disponible.',
                      'success'
                    )
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelado',
                      'Tu habitacióm sigue Ocupada :)',
                      'error'
                    )
                  }
                })
            },

        addAcomp(){

            if(this.name_acomp!="" && this.firstSurname_acomp!="" && this.secondSurname_acomp!="" && this.cedula_acomp!="" && this.birth_date_acomp!=""){

                this.listAcomp.push({name_acomp:this.name_acomp, firstSurname_acomp:this.firstSurname_acomp, secondSurname_acomp:this.secondSurname_acomp,
                                                        cedula_acomp:this.cedula_acomp, birth_date_acomp:this.birth_date_acomp});
                this.name_acomp = '';
                this.firstSurname_acomp = '';
                this.secondSurname_acomp = '';
                this.cedula_acomp = '';
                this.birth_date_acomp = '';
            }
            else{
                alert("Por favor ingrese todos los campos del formulario gracias.")
            }

        },
        deleteAcomp(acomp){

           var index =  this.listAcomp.indexOf(acomp);
           this.listAcomp.splice(index,1);

        },


        addProduct(product){
              console.log(product);

            this.listProduct.push({name_product:product.name_product, sale_product:product.sale_product, cantidad_product:this.cantidad_product,
                                total:product.sale_product*this.cantidad_product, url_img:product.img_product});

        },
        deleteProduct(product){

           var index =  this.listProduct.indexOf(product);
           this.listProduct.splice(index,1);

        },

        updateCustomers(page,search,valor){

                let me = this;
                var url = 'customers/update?page=' + page + '&search='+ search + "&valor=" + valor;
                axios.put(url,{

                            'id' : this.client_id,
                            'cedula_client' :    this.cedula_client,
                            'name_client' :    this.name_client,
                            'firstSurname_client' :   this.firstSurname_client,
                            'secondSurname_client'    : this.secondSurname_client,
                            'birth_date_client'    : this.birth_date_client,
                            'gender_client'    : this.gender_client,
                            'age_client'    : this.age_client,
                            'address_client'    : this.address_client,
                            'city_client'    : this.city_client,
                            'nationality_client'    : this.nationality_client,
                            'state_client'    : this.state_client,
                            'phone_client'    : this.phone_client,
                            'email_client'    : this.email_client,


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

    
    .disponible{
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


    .disponible i{
      font-size: 45px;
      color:rgb(33, 136, 56) ;
    }

    .disponible h3{
      font-size: 24px;
      color:rgb(33, 136, 56) ;
    }

    .disponible:hover{
      background-color: rgba(15, 225, 61, 0.4) ;
      color: #000;
      transform: scaleY(1.05);
    }

    .disponible:hover h3{
      color: #000;
    }

    .disponible:hover i{
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

    .Ocupada h3{
      font-size: 24px;
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

    .Ocupada:hover h3{
      color: #000;
    }

    .certificate label {
       font-size: 30px;
       padding-right: 10px;
    }
    .certificate h2{
       color: rgb(235, 23, 23);
       font-size: 40px;
    }

    .form_certificate{
      overflow: auto;
    }

    .imgProduct{
    width: 60px;
    height: 60px;
    }

    .product_img .imgProduct{
        width: 100%;
    }

    .img_products{
        width: 100px;
        height: 100px;
    }

    .imgProduct img{
        width: 100%;
    }

</style>
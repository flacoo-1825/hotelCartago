@extends('listado')
@section('content')
    <!--start here Data-->
    <!-- <principal></principal>-->


   
    <reception v-if="indice==0"></reception>
    <type-room v-if="indice==1"></type-room>
    <room v-if="indice==2"></room>
    <links v-if="indice==8"></links>
    <worker v-if="indice==9"></worker>
    <certificate v-if="indice==16"></certificate>
    <client v-if="indice==17"></client>
    <category v-if="indice==20"></category>
    <product v-if="indice==21"></product>
    <provider v-if="indice==22"></provider>
    <companion v-if="indice==23"></companion>


        <!--Inicio del modal agregar/actualizar-->
    
    <!-- Fin del modal Eliminar -->
@endsection
<template>
  <div>
    <listado-categoria></listado-categoria>
    <mapa-establecimientos></mapa-establecimientos>
    <categoria-cafe></categoria-cafe>
    <categoria-restaurant></categoria-restaurant>
    <categoria-hotel></categoria-hotel>
  </div>
</template>

<script>
import MapaEstablecimientos from "./MapaEstablecimientos";
import CategoriaCafe from "./CategoriaCafe";
import CategoriaRestaurant from "./CategoriaRestaurant";
import CategoriaHotel from "./CategoriaHotel";
import ListadoCategoria from "./ListadoCategoria";


export default {
  components: {
    MapaEstablecimientos,
    CategoriaCafe,
    CategoriaRestaurant,
    CategoriaHotel,
    ListadoCategoria,
  },
};
</script>

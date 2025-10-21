<template>

  <div class="col-sm-12 col-md-6 offset-md-3 mt-5" v-if="loading == false">
    <div class="d-flex align-items-center justify-content-between">
      <img width="100px" :src="jw_image" alt="" srcset="">
      <h2>JW Family Coordinates</h2>
    </div>
    <div class="mt-3">
      <div class="alert alert-info">
        Please put on location in your phone and enable location.
        Android users only
      </div>

      <div :class="['alert', error ? 'alert-danger' : 'alert-success']" v-if="message">
        {{ message }}
      </div>

      <div>
        <div class="instructions" v-if="!(gps.latitude && gps.latitude)">
          <ul class="list-group">
            <li class="list-group-item"> <b>Step 1: </b> Turn on location in your phone</li>
            <li class="list-group-item"> <b>Step 2: </b> Allow location access</li>
          </ul>
          <button class="btn btn-primary my-1" @click="getGPSCoordinate">REQUEST LOCATION ACCESS</button>
        </div>
        <div class="located my-2" v-if="gps.latitude && gps.longitude">
          <dl class="row">
            <dt class="col-sm-3">Longitude: </dt>
            <dd class="col-sm-9">{{ gps.longitude }}</dd>
            <dt class="col-sm-3">Latitude: </dt>
            <dd class="col-sm-9">{{ gps.latitude }}</dd>
          </dl>
          <button v-if="sent" @click="refresh()">REFRESH</button>
          <form @submit.prevent="save" v-else>
            <div class="form-floating mb-3">
              <select required v-model="gps.congregation" id="" class="form-control">
                <option v-for="congregation in congregations" :value="congregation.code">
                  {{ congregation.name }}
                </option>
              </select>
              <label for="formId1">Your Congregation</label>
            </div>
            <div class="form-group">
              <div class="form-floating mb-3">
                <input required type="text" class="form-control" v-model="gps.name" id="formId1" placeholder="" />
                <label for="formId1">Family Head Name</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" v-model="gps.phone"
                  required id="formId1" placeholder="" />
                <label for="formId1">Phone number</label>
              </div>
              <div class="form-floating mb-3">
                <input type="number" inputmode="numeric" pattern="[0-9]*" class="form-control" v-model="gps.publishers"
                  required id="formId1" placeholder="" />
                <label for="formId1">Number of publishers</label>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="loader" v-else>
    <h1>Please wait...</h1>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';

import jw_image from "@/assets/images/jw.png"
const allowed_access = ref(false);

const message = ref("");
const loading = ref(true);
const error = ref(false);
const sent = ref(false);

const base = ref("https://jwfamily.megamindsetsolutions.com/backend/");

// const base = ref("http://127.0.0.1:8000/");


const congregations = ref([]);

const gps = reactive({
  congregation: null,
  longitude: null,
  latitude: null,
  name: null,
  phone: null,
  publishers: null
})

onMounted(() => {
  setTimeout(() => {
    loading.value = false;
  }, 1000);
  getCongregations()
})

const refresh = function () {
  window.location.reload();
}

const save = async function () {
  loading.value = true;
  const form = new FormData();
  form.append('congregation', gps.congregation);
  form.append('name', gps.name);
  form.append('phone', gps.phone);
  form.append('publishers', gps.publishers);
  form.append('longitude', gps.longitude);
  form.append('latitude', gps.latitude);

  const request = await fetch(`${base.value}save.php`, {
    method: 'POST',
    body: form
  }).then(response => response.json()).catch(error => {
    error.value = true;
    message.value = error;
  }).finally(() => {
    loading.value = false;
  });

  if (request.success == true) {
    error.value = false;
    message.value = request.message;
    sent.value = true;
  } else {
    error.value = true;
    message.value = request.message;
  }


}


const getGPSCoordinate = function () {
  if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(

      // Success callback
      (position) => {
        console.log("Positioned");

        const latitude = Number.parseFloat(position.coords.latitude).toFixed(6);
        const longitude = Number.parseFloat(position.coords.longitude).toFixed(6);
        gps.latitude = latitude;
        gps.longitude = longitude
        loading.value = false;
      },
      // Error callback
      (err) => {
        switch (err.code) {
          case err.PERMISSION_DENIED:
            message.value = "Permission denied. Please allow location access.";
            break;
          case err.POSITION_UNAVAILABLE:
            message.value = "Location information unavailable.";
            break;
          case err.TIMEOUT:
            message.value = "Location request timed out. You did not respond on time";
            break;
          default:
            message.value = "An unknown error occurred.";
        }
      }
    );
  } else {
    message.value = "Geolocation is not supported by this browser, Geolocation not supported";
  }
  loading.value = false;
}

const getCongregations = async function () {
  loading.value = true;
  const request = await fetch(`${base.value}congregations.php`, {
    method: 'GET',
  }).then(response => response.json()).catch(error => {
    error.value = true;
    message.value = error;
  }).finally(() => {
    loading.value = false;
  });
  congregations.value = request.congregations;

}

</script>


<style>
.loader {
  height: 80vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
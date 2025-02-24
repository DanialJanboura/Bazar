<script setup>
import {ref, computed, watch} from 'vue';
import {Head, useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props passed from the controller
const props = defineProps({
  categories: {
    type: Array,
    required: true
  },
  extraFields: {
    type: Array,
    required: true
  }
});

// Reactive state for category selection and modal
const selectedMainCategory = ref('');
const selectedSubCategory = ref('');
const showModal = ref(false); // controls modal visibility

// Use Inertia's useForm to initialize form data
const form = useForm({

  category_id: '',
  title: '',
  slug: '',
  description: '',
  price: '',
  condition: '',
  location: '',
  status: '',
  extra_fields: {}      // will hold extra fields dynamically
});

// Compute main and subcategories from props
const mainCategories = computed(() =>
    props.categories.filter(category => category.parent_id === null)
);

const subCategories = computed(() =>
    props.categories.filter(category => category.parent_id === selectedMainCategory.value)
);

// Compute extra fields for the selected subcategory
const extraFieldsForSubcategory = computed(() =>
    props.extraFields.filter(field => field.category_id === selectedSubCategory.value)
);

// Watch subcategory changes to update form data and initialize extra fields
watch(selectedSubCategory, (newSubCategory) => {
  if (newSubCategory) {
    form.category_id = newSubCategory;
    extraFieldsForSubcategory.value.forEach(field => {
      if (!(field.name in form.extra_fields)) {
        form.extra_fields[field.name] = '';
      }
    });
  }
});

// Function to submit form using Inertia
const submitListing = () => {
  form.post(route('listings.store'), {
    onSuccess: () => {
      form.reset();
      showModal.value = false; // Close modal on success
    }
  });
};
</script>

<template>
  <Head title="New Listing"/>
  <authenticated-layout>
    <div class="new-listing">
      <form @submit.prevent="submitListing">
        <!-- Main Category Dropdown -->
        <div class="form-group">
          <label for="main_category">Main Category:</label>
          <select v-model="selectedMainCategory" id="main_category">
            <option value="" disabled>Select a main category</option>
            <option v-for="category in mainCategories"
                    :key="category.id"
                    :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <!-- Subcategory Dropdown -->
        <div class="form-group" v-if="selectedMainCategory">
          <label for="sub_category">Sub Category:</label>
          <select v-model="selectedSubCategory" id="sub_category">
            <option value="" disabled>Select a sub category</option>
            <option v-for="category in subCategories"
                    :key="category.id"
                    :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <!-- Listing Fields and Extra Fields -->
        <div v-if="selectedSubCategory">
          <!-- Static Listing Fields -->
          <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" v-model="form.title"/>
          </div>

          <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" v-model="form.description"></textarea>
          </div>


          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" v-model="form.price"/>
          </div>

          <!-- Dynamically Render Extra Fields -->
          <div v-for="field in extraFieldsForSubcategory"
               :key="field.id"
               class="form-group">

            <label :for="field.name">{{ field.label }}</label>
            <input v-if="field.field_type === 'text'"
                   type="text"
                   :id="field.name"
                   v-model="form.extra_fields[field.name]"/>

            <input v-if="field.field_type === 'number'"
                   type="number"
                   :id="field.name"
                   v-model="form.extra_fields[field.name]"/>


            <select v-else-if="field.field_type === 'select'"
                    :id="field.name"
                    v-model="form.extra_fields[field.name]">
              <option value="" disabled>Select an option</option>
              <option v-for="option in field.options"
                      :key="option"
                      :value="option">
                {{ option }}
              </option>
            </select>
            <!-- Add additional input types as needed -->
          </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group" v-if="selectedSubCategory">
          <button type="submit">Submit Listing</button>
        </div>
      </form>
    </div>
  </authenticated-layout>
</template>

<style scoped>
.new-listing {
  max-width: 600px;
  margin: 0 auto;
}

.form-group {
  margin-bottom: 1rem;
}
</style>

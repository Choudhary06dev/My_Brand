@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Edit Product</h1>
                <!-- <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg> Back
                </a> -->
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Product Name -->
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="product_name" id="product_name"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                required value="{{ old('product_name', $product->product_name) }}">
                            @error('product_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Product Type -->
                        <div>
                            <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Product Type (e.g. 1 Piece, 3 Piece)</label>
                            <input type="text" name="product_type" id="product_type"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                value="{{ old('product_type', $product->product_type ?? '1 Piece') }}">
                            @error('product_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <label for="subcategory_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" {{ $product->subcategory_id ? '' : 'disabled' }}
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm {{ $product->subcategory_id ? '' : 'bg-gray-100' }}">
                                <option value="">Select Subcategory</option>
                                @if($product->subcategory_id && $product->subcategory)
                                    <option value="{{ $product->subcategory_id }}" selected>{{ $product->subcategory->category_name }}</option>
                                @endif
                            </select>
                            @error('subcategory_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Child Subcategory -->
                        <div>
                            <label for="child_subcategory_id" class="block text-sm font-medium text-gray-700 mb-1">Child Subcategory</label>
                            <select name="child_subcategory_id" id="child_subcategory_id" {{ $product->child_subcategory_id ? '' : 'disabled' }}
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm {{ $product->child_subcategory_id ? '' : 'bg-gray-100' }}">
                                <option value="">Select Child Subcategory</option>
                                @if($product->child_subcategory_id && $product->childSubcategory)
                                    <option value="{{ $product->child_subcategory_id }}" selected>{{ $product->childSubcategory->category_name }}</option>
                                @endif
                            </select>
                            @error('child_subcategory_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>


                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Regular Price</label>
                            <input type="number" step="0.01" name="price" id="price"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                value="{{ old('price', $product->price) }}">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Purchase Price (Admin Only) -->
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Purchase Price (Admin Only)</label>
                            <input type="number" step="0.01" name="purchase_price" id="purchase_price"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                value="{{ old('purchase_price', $product->purchase_price) }}">
                            @error('purchase_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Discount Price -->
                        <div>
                            <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Discount Price</label>
                            <input type="number" step="0.01" name="discount_price" id="discount_price"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                value="{{ old('discount_price', $product->discount_price) }}">
                            @error('discount_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Color Selection -->
                        <div x-data="{ 
                            open: false, 
                            selected: '{{ old('color', $product->color) }}' ? '{{ old('color', $product->color) }}'.split(',').map(c => c.trim()).filter(c => c) : [],
                            commonColors: [
                                { name: 'Black', code: '#000000' },
                                { name: 'White', code: '#FFFFFF' },
                                { name: 'Red', code: '#EF4444' },
                                { name: 'Blue', code: '#3B82F6' },
                                { name: 'Green', code: '#10B981' },
                                { name: 'Yellow', code: '#F59E0B' },
                                { name: 'Grey', code: '#6B7280' },
                                { name: 'Navy', code: '#1E3A8A' },
                                { name: 'Beige', code: '#F5F5DC' },
                                { name: 'Pink', code: '#EC4899' }
                            ],
                            customColor: '',
                            addCustom() {
                                let val = this.customColor.trim();
                                if (val && !this.selected.includes(val)) {
                                    this.selected = [...this.selected, val];
                                    this.customColor = '';
                                }
                            },
                            toggleColor(colorName) {
                                if (this.selected.includes(colorName)) {
                                    this.selected = this.selected.filter(c => c !== colorName);
                                } else {
                                    this.selected = [...this.selected, colorName];
                                }
                            }
                        }" class="relative" @click.away="open = false">
                            <label for="color_display" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                            
                            <!-- Hidden input for the actual form submission -->
                            <input type="hidden" name="color" :value="selected.join(', ')">

                            <!-- Dropdown Trigger -->
                            <div @click="open = !open"
                                class="w-full bg-white border border-gray-300 rounded-lg shadow-sm px-4 py-2 cursor-pointer flex justify-between items-center focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                                <div class="flex flex-wrap gap-1 items-center overflow-hidden">
                                    <template x-if="selected.length === 0">
                                        <span class="text-gray-400">Select Colors</span>
                                    </template>
                                    <template x-for="color in selected" :key="color">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <span x-text="color"></span>
                                            <button type="button" @click.stop="toggleColor(color)" class="ml-1 text-indigo-400 hover:text-indigo-600">
                                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>
                                <svg class="h-5 w-5 text-gray-400 transform transition-transform ml-2 shrink-0" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl p-4">
                                
                                <div class="grid grid-cols-5 gap-3 mb-4">
                                    <template x-for="color in commonColors" :key="color.name">
                                        <button type="button" 
                                            @click="toggleColor(color.name)"
                                            class="flex flex-col items-center gap-1 group">
                                            <div class="h-8 w-8 rounded-full border-2 transition-all duration-200 flex items-center justify-center shadow-sm"
                                                :style="'background-color: ' + color.code"
                                                :class="selected.includes(color.name) ? 'border-indigo-600 ring-2 ring-indigo-200 scale-110' : 'border-gray-200 hover:border-gray-300'">
                                                <svg x-show="selected.includes(color.name)" class="h-4 w-4" :class="color.name === 'White' || color.name === 'Beige' ? 'text-gray-800' : 'text-white'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-[10px] text-gray-500 font-medium" x-text="color.name"></span>
                                        </button>
                                    </template>
                                </div>

                                <div class="border-t border-gray-100 pt-3">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" x-model="customColor" @keydown.enter.prevent="addCustom()"
                                            class="flex-1 text-sm rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 py-1.5" 
                                            placeholder="Custom color...">
                                        <button type="button" @click="addCustom()"
                                            class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-semibold transition-colors">Add</button>
                                    </div>

                                    <!-- Added Custom Colors List -->
                                    <div class="flex flex-col gap-1 max-h-32 overflow-y-auto">
                                        <template x-for="color in selected.filter(c => !commonColors.map(cc => cc.name).includes(c))" :key="color">
                                            <div class="flex items-center justify-between px-2 py-1 bg-gray-50 rounded text-xs">
                                                <span x-text="color" class="font-medium text-gray-700"></span>
                                                <button type="button" @click="toggleColor(color)" class="text-red-400 hover:text-red-600">
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Size Selection -->
                        <div x-data="{ 
                            open: false, 
                            selected: '{{ old('size', $product->size) }}' ? '{{ old('size', $product->size) }}'.split(',').map(s => s.trim()).filter(s => s) : [],
                            commonSizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '4XL', '5XL'],
                            customSize: '',
                            addCustom() {
                                let val = this.customSize.trim();
                                if (val && !this.selected.includes(val)) {
                                    this.selected = [...this.selected, val];
                                    this.customSize = '';
                                }
                            },
                            toggleSize(size) {
                                if (this.selected.includes(size)) {
                                    this.selected = this.selected.filter(s => s !== size);
                                } else {
                                    this.selected = [...this.selected, size];
                                }
                            }
                        }" class="relative" @click.away="open = false">
                            <label for="size_display" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                            
                            <!-- Hidden input for the actual form submission -->
                            <input type="hidden" name="size" :value="selected.join(', ')">

                            <!-- Dropdown Trigger -->
                            <div @click="open = !open"
                                class="w-full bg-white border border-gray-300 rounded-lg shadow-sm px-4 py-2 cursor-pointer flex justify-between items-center focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                                <span x-text="selected.length > 0 ? selected.join(', ') : 'Select Sizes'"
                                    class="text-gray-700 truncate" :class="selected.length === 0 && 'text-gray-400'"></span>
                                <svg class="h-5 w-5 text-gray-400 transform transition-transform" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl py-2 max-h-60 overflow-y-auto">
                                
                                <template x-for="size in commonSizes" :key="size">
                                    <label class="flex items-center px-4 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" :value="size" :checked="selected.includes(size)" @change="toggleSize(size)"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                        <span class="ml-3 text-sm text-gray-700" x-text="size"></span>
                                    </label>
                                </template>

                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <!-- Custom Size Input -->
                                <div class="px-4 py-2">
                                    <div class="flex gap-2">
                                        <input type="text" x-model="customSize" @keydown.enter.prevent="addCustom()"
                                            class="flex-1 text-xs rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 py-1" 
                                            placeholder="Custom...">
                                        <button type="button" @click="addCustom()"
                                            class="px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 text-xs font-bold">Add</button>
                                    </div>
                                </div>

                                <!-- Display Custom Selected (that aren't in common) -->
                                <template x-for="size in selected.filter(s => !commonSizes.includes(s))" :key="size">
                                    <label class="flex items-center px-4 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" checked @change="toggleSize(size)"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                        <span class="ml-3 text-sm text-gray-700 font-medium" x-text="size"></span>
                                    </label>
                                </template>
                            </div>
                            @error('size') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Special Effects -->
                        <div>
                            <label for="special_effects" class="block text-sm font-medium text-gray-700 mb-1">Special Effects</label>
                            <input type="text" name="special_effects" id="special_effects"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                value="{{ old('special_effects', $product->special_effects) }}">
                            @error('special_effects') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Washing & Dyeing Category -->
                        <div>
                            <label for="washing_dyeing_category" class="block text-sm font-medium text-gray-700 mb-1">Washing & Dyeing Category</label>
                            <input type="text" name="washing_dyeing_category" id="washing_dyeing_category"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                value="{{ old('washing_dyeing_category', $product->washing_dyeing_category) }}">
                            @error('washing_dyeing_category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fabric Category -->
                        <div>
                            <label for="fabric_category_id" class="block text-sm font-medium text-gray-700 mb-1">Fabric Category</label>
                            <select name="fabric_category_id" id="fabric_category_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="">Select Fabric Category</option>
                                @foreach($fabricCategories as $fCategory)
                                    <option value="{{ $fCategory->id }}" {{ old('fabric_category_id', $product->fabric_category_id) == $fCategory->id ? 'selected' : '' }}>
                                        {{ $fCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fabric_category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fabric -->
                        <div>
                            <label for="fabric_id" class="block text-sm font-medium text-gray-700 mb-1">Fabric</label>
                            <select name="fabric_id" id="fabric_id" {{ $product->fabric_id ? '' : 'disabled' }}
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm {{ $product->fabric_id ? '' : 'bg-gray-100' }}">
                                <option value="">Select Fabric</option>
                                @if($product->fabric_id && $product->fabric)
                                    <option value="{{ $product->fabric_id }}" selected>{{ $product->fabric->name }}</option>
                                @endif
                                @if(isset($fabrics))
                                    @foreach($fabrics as $f)
                                        @if($f->id != $product->fabric_id)
                                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('fabric_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Main Image -->
                        <div>
                            <label for="main_image" class="block text-sm font-medium text-gray-700 mb-1">Main Image</label>
                            @if($product->main_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="Preview" class="h-20 w-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="main_image" id="main_image"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('main_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Product Gallery -->
                        <div>
                            <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-1">Product Gallery (Add More)</label>
                            <input type="file" name="gallery_images[]" id="gallery_images" multiple
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('gallery_images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Existing Gallery -->
                        @if($product->galleries->count() > 0)
                        <div class="col-span-full mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Existing Gallery Images</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                                @foreach($product->galleries as $gallery)
                                <div class="relative group gallery-item-{{ $gallery->id }}">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="h-24 w-full object-cover rounded-lg border border-gray-100 shadow-sm">
                                    <button type="button" onclick="deleteGalleryImage({{ $gallery->id }})" 
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600 shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Status & Sale -->
                        <div class="flex items-center gap-6 mt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="status" id="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="status" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_sale" id="is_sale" value="1" {{ old('is_sale', $product->is_sale) ? 'checked' : '' }}
                                    class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                <label for="is_sale" class="ml-2 block text-sm text-gray-900 font-bold">Is on Sale?</label>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('description', $product->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">Cancel</a>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">Update
                            Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const getSubcategoriesRoute = "{{ url('admin/get-subcategories') }}";
        const currentSubcategoryId = "{{ $product->subcategory_id }}";
        const currentChildSubcategoryId = "{{ $product->child_subcategory_id }}";

        function loadDropdown(parentId, targetSelectId, selectedId = null, nextSelectId = null) {
            var targetSelect = document.getElementById(targetSelectId);
            var placeholder = targetSelect.getAttribute('id') === 'subcategory_id' ? 'Subcategory' : 'Child Subcategory';
            
            // Clear target and disable it
            targetSelect.innerHTML = `<option value="">Select ${placeholder}</option>`;
            targetSelect.disabled = true;
            targetSelect.classList.add('bg-gray-100');

            // If there's a next level, reset it too
            if (nextSelectId) {
                var nextSelect = document.getElementById(nextSelectId);
                var nextPlaceholder = 'Child Subcategory';
                nextSelect.innerHTML = `<option value="">Select ${nextPlaceholder}</option>`;
                nextSelect.disabled = true;
                nextSelect.classList.add('bg-gray-100');
            }

            if(parentId) {
                fetch(`${getSubcategoriesRoute}/${parentId}`)
                    .then(response => response.json())
                    .then(data => {
                        if(data.length > 0) {
                            targetSelect.disabled = false;
                            targetSelect.classList.remove('bg-gray-100');
                            data.forEach(item => {
                                var option = document.createElement('option');
                                option.value = item.id;
                                option.text = item.category_name;
                                if(selectedId && item.id == selectedId) {
                                    option.selected = true;
                                }
                                targetSelect.appendChild(option);
                            });

                            // If we have a selected ID and a next level to load
                            if (selectedId && nextSelectId) {
                                loadDropdown(selectedId, nextSelectId, currentChildSubcategoryId);
                            }
                        }
                    })
                    .catch(error => console.error(`Error fetching ${placeholder}:`, error));
            }
        }

        document.getElementById('category_id').addEventListener('change', function() {
            loadDropdown(this.value, 'subcategory_id', null, 'child_subcategory_id');
        });

        document.getElementById('subcategory_id').addEventListener('change', function() {
            loadDropdown(this.value, 'child_subcategory_id');
        });

        if(initialCategoryId) {
            loadDropdown(initialCategoryId, 'subcategory_id', currentSubcategoryId, 'child_subcategory_id');
        }

        const getFabricsRoute = "{{ url('admin/get-fabrics') }}";
        const currentFabricId = "{{ $product->fabric_id }}";

        function loadFabrics(categoryId, selectedId = null) {
            var fabricSelect = document.getElementById('fabric_id');
            fabricSelect.innerHTML = '<option value="">Select Fabric</option>';
            fabricSelect.disabled = true;
            fabricSelect.classList.add('bg-gray-100');

            if(categoryId) {
                fetch(`${getFabricsRoute}/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if(data.length > 0) {
                            fabricSelect.disabled = false;
                            fabricSelect.classList.remove('bg-gray-100');
                            data.forEach(fabric => {
                                var option = document.createElement('option');
                                option.value = fabric.id;
                                option.text = fabric.name;
                                if(selectedId && fabric.id == selectedId) {
                                    option.selected = true;
                                }
                                fabricSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching fabrics:', error));
            }
        }

        document.getElementById('fabric_category_id').addEventListener('change', function() {
            loadFabrics(this.value);
        });

        // Initialize fabrics if category is selected
        const initialFabricCategoryId = document.getElementById('fabric_category_id').value;
        if(initialFabricCategoryId) {
            loadFabrics(initialFabricCategoryId, currentFabricId);
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            if(typeof CKEDITOR !== 'undefined' && document.getElementById('description')) {
                CKEDITOR.replace('description');
            }
        });

        function deleteGalleryImage(id) {
            if(!confirm('Are you sure you want to delete this gallery image?')) return;

            fetch(`{{ url('admin/products/gallery') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Remove the element from UI
                    const element = document.querySelector(`.gallery-item-${id}`);
                    if(element) element.remove();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the image.');
            });
        }
    </script>
    @endpush
@endsection
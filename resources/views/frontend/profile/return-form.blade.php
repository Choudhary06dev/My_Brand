@extends('frontend.layouts.app')

@section('title', 'Return Request #' . $order->order_number . ' - ' . config('app.name'))

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container-custom">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-gray-200/50 border border-gray-100">
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 transform -rotate-6">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <h1 class="text-4xl font-black text-gray-900 mb-3 tracking-tight">Return Request</h1>
                    <p class="text-gray-500 font-bold">Order #{{ $order->order_number }}</p>
                </div>

                <form action="{{ route('frontend.profile.order-return.store', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Reason for Return <span class="text-red-500">*</span></label>
                        <select name="reason" required class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-indigo-600 focus:ring-0 outline-none transition-all font-bold text-gray-700">
                            <option value="" selected disabled>Select a reason</option>
                            <option value="Damaged on Arrival">Damaged on Arrival</option>
                            <option value="Wrong Item Received">Wrong Item Received</option>
                            <option value="Defective / Non-Functional">Defective / Non-Functional</option>
                            <option value="Product Not as Described">Product Not as Described</option>
                            <option value="Size / Fitment Issue">Size / Fitment Issue</option>
                            <option value="Quality Concerns">Quality Concerns</option>
                            <option value="Other">Other (Please specify in description)</option>
                        </select>
                        @error('reason') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Detailed Description <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" required minlength="10" 
                                  placeholder="Please explain the issue in detail..."
                                  class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-indigo-600 focus:ring-0 outline-none transition-all font-bold text-gray-700 resize-none">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Upload Photos (Max 3) <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <input type="file" name="images[]" multiple accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full px-8 py-12 bg-indigo-50/30 border-2 border-dashed border-indigo-100 rounded-[2rem] flex flex-col items-center justify-center group-hover:bg-indigo-50/50 group-hover:border-indigo-200 transition-all text-center">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-indigo-600 text-2xl mb-4 shadow-sm">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <p class="text-indigo-900 font-black text-sm mb-1 uppercase tracking-widest">Click to upload photos</p>
                                <p class="text-indigo-400 text-xs font-bold uppercase tracking-widest opacity-60">PNG, JPG up to 2MB each</p>
                            </div>
                        </div>
                        @error('images.*') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full px-8 py-5 bg-indigo-600 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] hover:bg-black hover:scale-[1.02] active:scale-95 transition-all duration-500 shadow-xl shadow-indigo-600/20">
                            Submit Return Request
                        </button>
                        <a href="{{ route('frontend.profile.order-detail', $order->order_number) }}" class="block text-center mt-6 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Go Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

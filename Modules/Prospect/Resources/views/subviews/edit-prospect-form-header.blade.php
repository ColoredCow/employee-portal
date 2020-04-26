<div class="theme-tabs-container">
    <div class="theme-tabs d-flex overflow-x-scroll mb-2 mx-md-auto">
        <div class="theme-tabs-inner font-muli-bold px-4 px-md-0 d-flex justify-content-md-center mx-md-auto">
            <div  onclick="window.location.href='{{ route('prospect.edit', [$prospect, 'prospect-details']) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2  {{ $section == 'prospect-details' ? 'active' : '' }}">Initial details
            </div> 

            <div  onclick="window.location.href='{{ route('prospect.edit', [$prospect, 'contact-persons']) }}'"  class="theme-tab c-pointer flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter hover-bg-theme-gray-light rounded-6  mr-1 mr-xl-2  {{ $section == 'contact-persons' ? 'active' : '' }}">Contact Persons</div> 

            {{-- <div  class="theme-tab disabled flex-center px-2 py-1 px-xl-6 py-xl-2 bg-theme-gray-lighter  rounded-6  mr-1 mr-xl-2  {{ $section == 'documents' ? 'active' : '' }}">Documents </div>  --}}
     
        </div>
    </div>
</div>
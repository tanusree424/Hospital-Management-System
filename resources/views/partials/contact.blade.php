 <div class="container-fluid pt-5">
     <div class="container">
         <div class="text-center mx-auto mb-5" style="max-width: 500px;">
             <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Any Questions?</h5>
             <h1 class="display-4">Please Feel Free To Contact Us</h1>
         </div>
         <div class="row g-5 mb-5">
             <div class="col-lg-4">
                 <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center text-center"
                     style="height: 200px;">
                     <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle mb-4"
                         style="width: 100px; height: 70px; transform: rotate(-15deg);">
                         <i class="fa fa-2x fa-location-arrow text-white" style="transform: rotate(15deg);"></i>
                     </div>
                     <h6 class="mb-0">KJ Sanyal Road Malda</h6>
                 </div>
             </div>
             <div class="col-lg-4">
                 <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center text-center"
                     style="height: 200px;">
                     <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle mb-4"
                         style="width: 100px; height: 70px; transform: rotate(-15deg);">
                         <i class="fa fa-2x fa-phone text-white" style="transform: rotate(15deg);"></i>
                     </div>
                     <h6 class="mb-0">+91 9332819707</h6>
                 </div>
             </div>
             <div class="col-lg-4">
                 <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center text-center"
                     style="height: 200px;">
                     <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle mb-4"
                         style="width: 100px; height: 70px; transform: rotate(-15deg);">
                         <i class="fa fa-2x fa-envelope-open text-white" style="transform: rotate(15deg);"></i>
                     </div>
                     <h6 class="mb-0">tbasuchoudhury@gmail.com</h6>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-12" style="height: 500px;">
                 <div class="position-relative h-100">
                     <iframe class="position-relative w-100 h-100"
                         src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14463.864228770386!2d88.13936639999999!3d25.0012693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1755703627526!5m2!1sen!2sin"
                         width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                         referrerpolicy="no-referrer-when-downgrade"></iframe>

                 </div>
             </div>
         </div>
         <div class="row justify-content-center position-relative" style="margin-top: -200px; z-index: 1;">
             <div class="col-lg-8">
                 <div class="bg-white rounded p-5 m-5 mb-0">
                     <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
                         @csrf
                         @if (session('success'))
                             <div class="alert alert-success">{{ session('success') }}</div>
                         @endif

                         @if ($errors->any())
                             <div class="alert alert-danger">
                                 <ul class="mb-0">
                                     @foreach ($errors->all() as $error)
                                         <li>{{ $error }}</li>
                                     @endforeach
                                 </ul>
                             </div>
                         @endif
                         <div class="row g-3">
                             <div class="col-12 col-sm-6">
                                 <input type="text" name="name" class="form-control bg-light border-0"
                                     placeholder="Your Name" style="height: 55px;">
                             </div>
                             <div class="col-12 col-sm-6">
                                 <input type="email" name="email" class="form-control bg-light border-0"
                                     placeholder="Your Email" style="height: 55px;">
                             </div>
                             <div class="col-12">
                                 <input type="text" name="subject" class="form-control bg-light border-0"
                                     placeholder="Subject" style="height: 55px;">
                             </div>
                             <div class="col-12">
                                 <textarea class="form-control bg-light border-0" name="message" rows="5" placeholder="Message"></textarea>
                             </div>
                             <div class="col-12">
                                 <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>

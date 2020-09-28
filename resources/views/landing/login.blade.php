@extends('landing.template')
@section('body')

<!-- sign-in -->
<section id="sign-in" class="bglight position-relative padding">
  <div class="container">
      <div class="row">
          <div class="col-lg-6 pr-0">
              <div class=" image login-image h-100">
                  <img src="images/login-section.jpg" alt="" class="w-100 h-100">
              </div>
          </div>
         <div class="col-lg-6 pl-0 col-md-8 col-sm-10 whitebox">
            <div class="widget logincontainer">
               <h3 class="darkcolor bottom35">Login </h3>
               <form class="getin_form border-form" id="login">
                  <div class="row">
                     <div class="col-md-12 col-sm-12">
                        <div class="form-group bottom35">
                            <label for="loginEmail" class="d-none"></label>
                           <input class="form-control" type="email" placeholder="Email:" required id="loginEmail">
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12">
                        <div class="form-group bottom35">
                            <label for="loginPass" class="d-none"></label>
                           <input class="form-control" type="password" placeholder="Password:" required id="loginPass">
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12">
                        <div class="form-group bottom35">

                           <div class="form-check text-left">
                              <input class="form-check-input" checked type="checkbox" value="" id="rememberMe">
                              <label class="form-check-label" for="rememberMe">
                                    Keep Me Signed In
                                </label>
                           </div>

                        </div>
                     </div>
                     <div class="col-sm-12">
                        <button type="submit" class="button gradient-btn btnprimary">Login</button>
                        <p class="top20 log-meta"> Don't have an account? <a href="sign-up.html">Sign Up Now</a> </p>
                     </div>
                  </div>
               </form>
            </div>
         </div>

      </div>
   </div>
</section>
<!-- sign-in ends -->

@endsection
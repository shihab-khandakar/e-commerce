@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Login</li>
    </ul>
    <h3> Login / Register</h3>
    <hr class="soft" />

    <div class="row">
        <div class="span4">
            <div class="well">
                <h5>CREATE YOUR ACCOUNT</h5><br />
                Enter your Name and E-mail address to create an account.<br /><br />
                <form action="register.html">
                    <div class="control-group">
                        <label class="control-label" for="inputName0">Name</label>
                        <div class="controls">
                            <input class="span3" type="text" id="inputName0" placeholder="Name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail0">E-mail address</label>
                        <div class="controls">
                            <input class="span3" type="text" id="inputEmail0" placeholder="Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword0">Password</label>
                        <div class="controls">
                            <input class="span3" type="password" id="inputPassword0" placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail0">Mobile</label>
                        <div class="controls">
                            <input class="span3" type="text" id="inputMobile0" placeholder="Enter Mobile Number">
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Create Your Account</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
                <h5>ALREADY REGISTERED ?</h5>
                <form>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail1">Email</label>
                        <div class="controls">
                            <input class="span3" type="text" id="inputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword1">Password</label>
                        <div class="controls">
                            <input type="password" class="span3" id="inputPassword1"
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Sign in</button> <a
                                href="forgetpass.html">Forget password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
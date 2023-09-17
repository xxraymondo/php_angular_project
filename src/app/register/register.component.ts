import {  Component} from '@angular/core';
import { FormControl,FormGroup,Validators } from '@angular/forms';
import { UserService } from '../user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent  {
  constructor(private _userService: UserService,private router: Router) {

  }
registerForm:FormGroup = new FormGroup({
    'name':new FormControl(null,[Validators.minLength(3),Validators.maxLength(20),Validators.required]),
    'email':new FormControl(null,[Validators.email,Validators.required]),
    'password':new FormControl(null,[Validators.minLength(10),Validators.maxLength(40),Validators.required]),
    'password_confirmation':new FormControl(null,[Validators.minLength(10),Validators.maxLength(40),Validators.required]),
   })
   getFormData(form:any){
    form=form.value
   if(this.registerForm.value.password==this.registerForm.value.password_confirmation){
    this._userService.register(form).subscribe(
      (value) => {
        let user={email:this.registerForm.value.email,
          password:this.registerForm.value.password}
        this._userService.login(user).subscribe((data)=>{
          window.alert("register success you are logged in");
          localStorage.setItem('token',data.token)

          this.router.navigate(['home']);
        },(err)=>{console.log(err)});
   },(err)=>{console.log(err)});
   }else{
    window.alert("password doesn't match")
   }
}
    // @ViewChild("passwordConfimation") passwordConfimation!: ElementRef;
    // @ViewChild("passwordConfimation") password!: ElementRef;
    // passwordValue = this.password.nativeElement.value
    // passwordConfimationValue = this.passwordConfimation.nativeElement.value

}

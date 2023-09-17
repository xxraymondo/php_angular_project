import { Component } from '@angular/core';
import { FormControl,FormGroup,Validators } from '@angular/forms';
import { UserService } from '../user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  constructor(private _userService: UserService,private router: Router) {

  }
  LoginForm:FormGroup = new FormGroup({

    'email':new FormControl(null,[Validators.email,Validators.required]),
    'password':new FormControl(null,[Validators.minLength(10),Validators.maxLength(40),Validators.required])
   })
   redirectTo(uri: string) {
    this.router.navigateByUrl('/home').then(() =>
    window.location.reload());
 }
   getFormData(form:any){
    form=form.value
    console.log(form)
    this._userService.login(form).subscribe(
      (value) => {console.log(value.user.role)
        localStorage.setItem('role',value.user.role)
        localStorage.setItem('name',value.user.name)
        localStorage.setItem('token',value.token)

        this.redirectTo("home")
   },(err)=>{console.log(err)});

}
}

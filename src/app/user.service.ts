import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private httpClient: HttpClient) {

  }
  register(user:any):Observable<any>{
   let userRequest= this.httpClient.post("http://localhost:8000/api/register",user);
    return userRequest;
  }
  login(user:any):Observable<any>{
    let userRequest= this.httpClient.post("http://localhost:8000/api/login",user);
    console.log(userRequest);
     return userRequest;
   }
}

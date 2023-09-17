import { Injectable } from '@angular/core';
import { HttpClient ,HttpHeaders} from '@angular/common/http';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class CartItemService {

  constructor(public http: HttpClient) {}
  private getHeaders() {
    const token = localStorage.getItem('token');
    console.log(token);
    if (token) {
      return new HttpHeaders({
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`, // Include the token as a bearer token
      });
    } else {
      return new HttpHeaders({
        'Content-Type': 'application/json',
      });
    }
  }
  getCartItems(){
    return this.http.get("http://localhost:8000/api/view-cart-items",{headers: this.getHeaders()})

  }

}

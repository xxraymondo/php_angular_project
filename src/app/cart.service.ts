import { Injectable } from '@angular/core';
import { HttpClient ,HttpHeaders} from '@angular/common/http';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class CartService {
   cartLength!: number;
  constructor(public http: HttpClient) {}
  private getHeaders() {
    const token = localStorage.getItem('token');
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
  addToCart(item:any):Observable<any>{
    let id=item.product_id
    item.product_subtotal=item.product_price
  return this.http.post(`http://localhost:8000/api/cart/add/${id}`,item,{headers: this.getHeaders()})
  }
  getCart():Observable<any>{
   let x= this.http.get("http://localhost:8000/api/view-cart-items",{headers: this.getHeaders()})
  return x;
  }
  delCart():Observable<any>{
    let x= this.http.delete("http://localhost:8000/api/cart/empty",{headers: this.getHeaders()})
   return x;
   }
   decreaseCartItem(item:any):Observable<any>{
    let id=item.id
    return this.http.post(`http://localhost:8000/api/cart/decrease/${item}`, {},{headers: this.getHeaders()})
  }
  increaseCartItem(item:any):Observable<any>{
    let id=item.id
    console.log(item)
    return this.http.post(`http://localhost:8000/api/cart/increase/${item}`, {},{headers: this.getHeaders()})
  }
  delCartItem(item:any):Observable<any>{
    console.log(item)
    return this.http.delete(`http://localhost:8000/api/remove-cart-item/${item}`,{headers: this.getHeaders()})

  }

}




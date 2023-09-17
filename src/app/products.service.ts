import { Injectable } from '@angular/core';
import { HttpClient,HttpHeaders } from '@angular/common/http';
import { Observable,BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {

  constructor(public httpClient: HttpClient) {}
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
  getProducts():Observable<any>{
   let x= this.httpClient.get("http://localhost:8000/api/products");
    return x
  }
  createProduct(product:any):Observable<any>{
    console.log(product);
    const token = localStorage.getItem('token');

    // Create headers with the token
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    });
    return this.httpClient.post("http://localhost:8000/api/products",{product},{ headers })
  }

}

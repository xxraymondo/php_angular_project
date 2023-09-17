import { Injectable } from '@angular/core';
import {BehaviorSubject} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DataSharingService {

  public CartLength: BehaviorSubject<any> = new BehaviorSubject<any>(0);
  notifyObservable$ = this.CartLength.asObservable();
  public role: BehaviorSubject<any> = new BehaviorSubject<any>(0);
  notifyObservableRole$ = this.role.asObservable();
  constructor() { }
}

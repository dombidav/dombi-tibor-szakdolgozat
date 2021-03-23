import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import {TokenStorageService} from './token-storage.service';
import * as env from '../../env.json';

const AUTH_API = `${env.WEB_SERVICE}/auth/`;

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  constructor(private http: HttpClient, private token: TokenStorageService) { }

  isRouteAuthenticated(): boolean{
    return this.token.getToken()?.length > 0
  }

  login(email: string, password: string): Observable<any> {
    return this.http.post(AUTH_API + 'signin', {
      email,
      password
    }, httpOptions);
  }

  register(name: string, email: string, password: string): Observable<any> {
    return this.http.post(AUTH_API + 'signup', {
      name,
      email,
      password,
      password_confirmation: password
    }, httpOptions);
  }
}

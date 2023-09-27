import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../../services/auth.service";
import {NzMessageService} from "ng-zorro-antd/message";
import {ActivatedRoute} from "@angular/router";
import {AuthenticationRequest} from "../../../entity/user";
import {tap} from "rxjs/operators";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  validateForm: FormGroup;

  isLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private nzMessageService: NzMessageService,
    private route: ActivatedRoute
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
    this.initForm();
    this.authService.localLogin();
  }

  initForm() {
    this.validateForm = this.formBuilder.group({
      username: [null, [Validators.required]],
      password: [null, [Validators.required]],
      remember: [false]
    });
  }

  submitForm(): void {
    this.isLoading = true;
    // tslint:disable-next-line:forin
    for (const i in this.validateForm.controls) {
      this.validateForm.controls[i].markAsDirty();
      this.validateForm.controls[i].updateValueAndValidity();
    }
    const {username, password} = this.validateForm.controls;
    if (username?.value && password?.value) {
      this.login({username: username.value, password: password.value})
        .subscribe(res => {
          if (!res.type) {
            this.nzMessageService.error(res.msg)
          }
        });
      ;
    }
  }

  private login(loginInfo: AuthenticationRequest) {
    this.isLoading = true;
    // this.authService.localLogin();
    return this.authService
      .login(loginInfo)
      .pipe(tap(_ => (this.isLoading = false)));
  }
}

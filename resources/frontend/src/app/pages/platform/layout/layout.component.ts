import {Component, OnInit} from '@angular/core';

import {AuthService} from "../../../services/auth.service";
import {NavigationEnd, Router} from "@angular/router";
import {PlatformLocation} from "@angular/common";
import {NzModalService} from "ng-zorro-antd/modal";
import {NavigationService} from "../../../services/system/navigation.service";
import {Navigation} from "../../../entity/system";

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.css']
})
export class LayoutComponent implements OnInit {

  isCollapsed = false;

  username?: string;

  menuItems: Navigation[] = [];

  constructor(
    private authService: AuthService,
    private router: Router,
    private platform: PlatformLocation,
    private modalService: NzModalService,
    private navigationService: NavigationService,
  ) {
  }

  ngOnInit(): void {
    this.getLink();
    this.initNavigationSelect();
    this.username = this.authService.username;
  }

  private getLink() {
    // this.navigationService.all()
    //   .pipe(map(v => {
    //     v.data.map((v2, i) => i === 0 ? (v2.select = true) : (v2.select = false))
    //     return v;
    //   })).subscribe(res => {
    //   if (res.code === 0) {
    //     // @ts-ignore
    //     this.menuItems = res.data
    //   }
    // })

    // @ts-ignore
    this.menuItems = this.authService.navigations;
  }

  /**
   * 初始化默认选中菜单
   */
  private initNavigationSelect() {
    const router = this.platform.pathname.substr(1);
    this.setMenuItem(router);
  }

  /**
   * 设置菜单选种项
   * @param router string
   */
  private setMenuItem(router: string) {
    this.menuItems.map(value => value.select = (value.navigation_router === router));
  }

  /**
   * 初始化路由监听事件，根据路由变化设置菜单选中事件
   */
  private initRouterEvent() {
    this.router.events.subscribe((data) => {
      if (data instanceof NavigationEnd) {
        this.setMenuItem(data.url.substr(1));
      }
    });
  }

  onLogout() {
    this.modalService.confirm({
      nzTitle: '登出提示',
      nzContent: '<b style="color: red;">点击登出后将会退出当前系统!</b>',
      nzOkText: '登出',
      nzCancelText: '取消',
      nzOnOk: () => {
        this.authService.localLogout();
      },
      nzOnCancel: () => {
        console.log('Cancel')
      }
    });
  }

  onResetPassword() {

  }
}

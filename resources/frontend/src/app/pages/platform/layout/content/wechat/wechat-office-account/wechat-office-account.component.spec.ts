import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WechatOfficeAccountComponent } from './wechat-office-account.component';

describe('WechatOfficeAccountComponent', () => {
  let component: WechatOfficeAccountComponent;
  let fixture: ComponentFixture<WechatOfficeAccountComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WechatOfficeAccountComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WechatOfficeAccountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

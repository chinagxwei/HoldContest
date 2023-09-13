import { ComponentFixture, TestBed } from '@angular/core/testing';

import { WechatMiniProgramAccountComponent } from './wechat-mini-program-account.component';

describe('WechatMiniProgramAccountComponent', () => {
  let component: WechatMiniProgramAccountComponent;
  let fixture: ComponentFixture<WechatMiniProgramAccountComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ WechatMiniProgramAccountComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(WechatMiniProgramAccountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

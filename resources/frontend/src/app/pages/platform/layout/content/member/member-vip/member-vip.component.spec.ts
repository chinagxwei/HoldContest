import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberVipComponent } from './member-vip.component';

describe('MemberVipComponent', () => {
  let component: MemberVipComponent;
  let fixture: ComponentFixture<MemberVipComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MemberVipComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MemberVipComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

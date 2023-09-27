import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SetMemberRechargeComponent } from './set-member-recharge.component';

describe('SetMemberRechargeComponent', () => {
  let component: SetMemberRechargeComponent;
  let fixture: ComponentFixture<SetMemberRechargeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SetMemberRechargeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SetMemberRechargeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SetMemberWithdrawalAccountComponent } from './set-member-withdrawal-account.component';

describe('SetMemberWithdrawalAccountComponent', () => {
  let component: SetMemberWithdrawalAccountComponent;
  let fixture: ComponentFixture<SetMemberWithdrawalAccountComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SetMemberWithdrawalAccountComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SetMemberWithdrawalAccountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

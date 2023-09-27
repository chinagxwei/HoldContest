import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SetMemberGameAccountComponent } from './set-member-game-account.component';

describe('SetMemberGameAccountComponent', () => {
  let component: SetMemberGameAccountComponent;
  let fixture: ComponentFixture<SetMemberGameAccountComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SetMemberGameAccountComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SetMemberGameAccountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { QuickAddRoomComponent } from './quick-add-room.component';

describe('QuickAddRoomComponent', () => {
  let component: QuickAddRoomComponent;
  let fixture: ComponentFixture<QuickAddRoomComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ QuickAddRoomComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(QuickAddRoomComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

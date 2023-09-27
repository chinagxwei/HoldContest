import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SettlementRoomComponent } from './settlement-room.component';

describe('SettlementRoomComponent', () => {
  let component: SettlementRoomComponent;
  let fixture: ComponentFixture<SettlementRoomComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SettlementRoomComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SettlementRoomComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
